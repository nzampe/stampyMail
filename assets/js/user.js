function deleteUser(id, e) {
    if (confirm('Está seguro de que quiere eliminar este usuario?')) {
        let formData = new FormData();
        formData.append('id', id)
        fetch(App.config.base_url+`/user/delete`,{
            method:'POST',
            body: formData
        })
        .then(function(response) {
            return response.text()
        })
        .then(function(response) {
            let data = JSON.parse(response);
            if(data.statusCode === 200) {
                alert(data.data);
                let row = document.getElementById("user-"+id);
                row.parentNode.removeChild(row);
            }
        });
    }
}

function actionUser(e) {
    e.preventDefault();
    let form = document.getElementById('user-form');
    let formData = new FormData(form);
    
    let url = App.config.base_url+'/user/'
    
    if(formData.get('id')) {
        url += 'edit' 
    }
    else {
        url += 'add' 
    }

    fetch(`${url}`,{
        method:'POST',
        body: formData
    })
    .then(function(response) {
        return response.text()
    })
    .then(function(response) {
        console.log(response)
        let data = JSON.parse(response);
        console.log(data)
        if(data.statusCode === 200) {
            alert(data.data);
            window.location.href=App.config.base_url+'/default/home'
        }
        else {
            document.getElementById('error').innerText = data.data;
            document.getElementById('error').style.color = "red";
        }
    });
}

function newUser() {
    window.location.href=App.config.base_url+'/user/formUser'
}
