define([
    "dojo/query",
    "dojo/router",
    "dojo/dom-style",
    "dojo/dom-attr",
    "dojo/request",
    "mustache/mustache",
    "dojo/dom-construct",
    "dojo/behavior",
    "dojo/dom-class",
    "clementia/equal-heights"
    ], function (query, router, domStyle, domAttr, request, mustache, domConstruct, behavior, domClass, eqHeights){
        var template = '{{#tests}}<div class="span4 test-list-item test-{{status}} clickable-element" data-link="{{link}}"><div class="test-list-item-inner"><h4>{{description}}</h4><div class="last-run"><small>{{site_domain}} &bull; {{lastruntext}} {{lastruntime}}</small></div></div></div>{{#new_row}}</div><div class="row">{{/new_row}}{{/tests}}{{{pagination}}}';

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

            router.register("/(.+)/(all|passing|failing|never-run)(/([0-9]+))?", function(e){
                foundRoute = true;
                self.load(e.params[0], e.params[1], e.params[3]);
                self.markActivePill(e.params[1]);
                self.markActiveSite(e.params[0]);
                self.changePillLinks(e.params[0]);
            });

            router.startup();

            if (!foundRoute) {
                router.go("/all/all");
            }
        };

        testList.markActivePill = function(status) {
            query(".test-filter-pills li").removeClass("active");

            var node = query(".test-filter-pills li." + status)[0];
            domClass.add(node, "active");
        };

        testList.markActiveSite = function(site) {
            if (site === 'all') {
                site = 'All Sites';
            }
            document.getElementById('active-site').innerText = site;
        };

        testList.changePillLinks = function(site) {
            domAttr.set("link-all", "href", "#/" + site + "/all");
            domAttr.set("link-passing", "href", "#/" + site + "/passing");
            domAttr.set("link-failing", "href", "#/" + site + "/failing");
            domAttr.set("link-never-run", "href", "#/" + site + "/never-run");
        };
        
        /**
         * Create the AJAX request and then delegate to render()
         * @param string status Filter tests by this status
         * @param integer page Page number to load
         */
        testList.load = function(site, status, page) {
            var results = null;
            var self = this;

            domConstruct.empty("test-list");
            domStyle.set("loading", "display", "block");

            request("/test/list", {
                query: {
                    site: site,
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
            domStyle.set("loading", "display", "none");

            if (results.tests.length > 0) {
                var html = mustache.render(template, results);
                html = '<div class="row">' + html + '</div>';

                domConstruct.place(html, "test-list");

                behavior.apply(); // apply clickable-element behavior to new elements
                eqHeights.makeEqual('.test-list .row', true); // make tests equal height
            } else {
                domConstruct.place("<p>No tests found</p>", "test-list");
            }
        };

        return testList;
    }
);