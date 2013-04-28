define([
    "dojo/query",
    "dojo/router",
    "dojo/dom-style",
    "dojo/request",
    "mustache/mustache",
    "dojo/dom-construct",
    "dojo/behavior",
    "dojo/dom-class",
    "clementia/equal-heights"
    ], function (query, router, domStyle, request, mustache, domConstruct, behavior, domClass, eqHeights){
        var template = '{{#tests}}<div class="span4 test-list-item test-{{status}} clickable-element" data-link="{{link}}"><div class="test-list-item-inner"><h4>{{description}}</h4><div class="last-run"><small class="{{lastrunclass}}">{{lastruntext}} {{lastruntime}}</small></div></div></div>{{#new_row}}</div><div class="row">{{/new_row}}{{/tests}}{{{pagination}}}';

        var testList = {};

        testList.build = function() {
            this.registerRoutes();
        };

        /**
         * Using dojo/router, create routes for hash paths to load
         * test list via AJAX
         */
        testList.registerRoutes = function() {
            var self = this;
            var foundRoute = false;

            router.register("/(all|passing|failing|never-run)(/([0-9]+))?", function(e){
                foundRoute = true;
                self.load(e.params[0], e.params[2]);
                self.markActivePill(e.params[0]);
            });

            router.startup();

            if (!foundRoute) {
                router.go("/all");
            }
        };

        testList.markActivePill = function(status) {
            query(".test-filter-pills li").removeClass("active");

            var node = query(".test-filter-pills li." + status)[0];
            domClass.add(node, "active");
        };
        
        /**
         * Create the AJAX request and then delegate to render()
         * @param string status Filter tests by this status
         * @param integer page Page number to load
         */
        testList.load = function(status, page) {
            var results = null;
            var self = this;

            domConstruct.empty("test-list");
            domStyle.set("loading", "display", "block");

            request("/test/list", {
                query: {
                    status: status,
                    page: page
                },
                handleAs: "json"
            }).then(function(results){
                self.render(results);
            });
        };

        /**
         * Render the results and pagination
         */
        testList.render = function(results) {
            var html = mustache.render(template, results);
            html = '<div class="row">' + html + '</div>';
            
            domStyle.set("loading", "display", "none");
            domConstruct.place(html, "test-list");

            behavior.apply(); // apply clickable-element behavior to new elements
            eqHeights.makeEqual('.test-list .row', true); // make tests equal height
        };

        return testList;
    }
);