function openView(model, id) {
    window.location.href = "/admin/" + model + "/view/" + id;
};

function openSupplierView(model, id) {
    window.location.href = "/supplier/" + model + "/view/" + id;
};

function openSupplierOverview(model, id) {
    window.location.href = "/supplier/" + model;
};

function openOverview(model) {
    window.location.href = "/admin/" + model;
};