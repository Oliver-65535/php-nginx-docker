

function getEmails(){
    const emails = document.getElementById("emails")

    const emails_array = ["test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com","test@testemail.com"];
    
    let html = "<table><tr><th>Emails:</th></tr>";

    emails_array.forEach(element => {
        html+= "<tr><td>"+element+"</td></tr>"
    });
    html += "</table>"

    emails.innerHTML = html;
}