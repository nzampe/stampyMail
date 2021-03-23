function login(e, base_url) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('username', document.getElementById('username').value)
    formData.append('password', document.getElementById('password').value)
    fetch(App.config.base_url+`/auth/login`,{
        method:'POST',
        body: formData
    })
        .then(function(response) {
            return response.text()
        })
        .then(function(response){
            let data = JSON.parse(response);
            if(data.statusCode === 200) {
                window.location.href=App.config.base_url+'/default/home'
            }
            else {
                document.getElementById('error').innerText = data.data;
                document.getElementById('error').style.color = "red";
            }
        });
}
