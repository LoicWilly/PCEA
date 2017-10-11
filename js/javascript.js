function httpGet(theUrl)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {

        }
    }
    xmlhttp.open("GET", theUrl, false);
    xmlhttp.send();
}

function DDB(idCom, idMotif, Com)
{
    httpGet("sendDDB.php?idCom="+idCom+"&idMotif="+idMotif+"&Com="+Com);
}

function Boost(idCom)
{
        httpGet("sendDDB.php?idCom="+idCom);
}