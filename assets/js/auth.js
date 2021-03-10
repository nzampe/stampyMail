function login(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('username', document.getElementById('username').value)
    formData.append('password', document.getElementById('password').value)
    fetch(`/stampymail/auth/login`,{
        method:'POST',
        body: formData
    })
        .then(function(response) {
            return response.text()
        })
        .then(function(response){
            let data = JSON.parse(response);
            if(data.statusCode === 200) {
                window.location.href='/stampymail/default/home'
            }
            else {
                document.getElementById('error').innerText = data.data;
                document.getElementById('error').style.color = "red";
            }
        });
}