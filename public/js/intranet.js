//Fonction de changement de couleur pour Notre dame (ND)
function intrand()
{
    document.getElementById("div_nd").style.display="block";
    document.getElementById("div_lp").style.display="none";
    document.getElementById("div_lg").style.display="none";
}

//Fonction de changement de couleur pour lycee professionnel (LP)
function intralp()
{
    document.getElementById("div_nd").style.display="none";
    document.getElementById("div_lp").style.display="block";
    document.getElementById("div_lg").style.display="none";
}

//Fonction de changement de couleur pour lycee general (LG)
function intralg()
{
    document.getElementById("div_nd").style.display="none";
    document.getElementById("div_lp").style.display="none";
    document.getElementById("div_lg").style.display="block";
}

// Author: Y. Merle
