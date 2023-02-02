const langElem = document.getElementById('lang')

function setLanguage(lang){
    localStorage.setItem('language',lang)
    langElem.innerHTML=lang
    console.log(lang)    
}


(function () {
    if (localStorage.getItem('language')) {
     
   } else {
    setLanguage("EN")
   }

   langElem.innerHTML=localStorage.getItem("language") 
   })();

