var App;
App = {
    submit: function (idForm,route) {
        if(idForm === null) idForm = 'formSubmit'
        $('#'+idForm).attr('action',route);
        $('#'+idForm).submit();
    }
};