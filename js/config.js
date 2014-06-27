// Utilidades basicas de java script

var URLINDEX = document.URL.substr(0,document.URL.indexOf('php')) + 'php';
var URLHOST = document.URL.substr(0,document.URL.indexOf('index.php'));

if (document.URL.indexOf('php') < 0){
    URLINDEX = document.URL + 'index.php';
}

var COD_DPTO = '22';
var COD_PROV = '09';
var COD_DIST = '01';