const btn = document.querySelector(".btn-toggle");
const theme = document.querySelector("#theme");
btn.addEventListener("click", function() {
  toggleTheme()
});

// function to set a given theme/color-scheme
function setTheme(themeName) {
  localStorage.setItem('theme', themeName);
  document.getElementById("theme").className = themeName;
  setImage(themeName);
}
// function to toggle between light and dark theme
function toggleTheme() {
 if (localStorage.getItem('theme') === 'theme-dark'){
     setTheme('theme-light');
 } else {
     setTheme('theme-dark');
 }

 setImage();
}
// Immediately invoked function to set the theme on initial load
(function () {
 if (localStorage.getItem('theme') === 'theme-dark') {
     setTheme('theme-dark');
 } else {
     setTheme('theme-light');
 }

 setImage();
})();

function setImage (themeName) {
  console.log('set image');
  const image = document.querySelector('.card-section-4 img');

  if(localStorage.getItem('theme') === 'theme-dark') {
    image.src = '/assets/imgs/howitworkblack.svg'
    
  } else {
    image.src = '/assets/imgs/howitwork.svg'
  }
};


