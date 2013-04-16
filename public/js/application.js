function byId(id) 
{
    return document.getElementById(id);
}

// set up Dojo Bootstrap JS
require(["bootstrap/Alert", "bootstrap/Dropdown"]);

// allow faking of request method and clickable elements
require(["clementia/fake-http-method", "clementia/clickable-element"]);