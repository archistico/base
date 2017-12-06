function DoSubmit(){
    // Crea un elemento di input che verrà usato come campo di output per la password criptata.
    var form = document.getElementById('login_form');
    var password_chiaro = document.getElementById('password_chiaro');
    var p = document.createElement("input");
    // Aggiungi un nuovo elemento al tuo form.
    form.appendChild(p);
    p.name = "password";
    p.type = "hidden"
    p.value = hex_sha512(password_chiaro.value);
    // Assicurati che la password non venga inviata in chiaro.
    password_chiaro.value = "";
    // Come ultimo passaggio, esegui il 'submit' del form.
    form.submit();
}