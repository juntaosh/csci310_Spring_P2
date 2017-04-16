var conferenceTitle;
var articleTitle;
$(document).ready(function() {
    var data = location.search;
    data = data.replace('?', '');
    var temp = data.split('&');
    var id = temp[0].replace('id=', '');
    conferenceTitle = temp[4].replace('title=', '');
    conferenceTitle = conferenceTitle.replace(/%20/g, ' ');
    console.log(id);
    var link = "http://dl.acm.org/citation.cfm?id=" + id + "&preflayout=flat";
    console.log(link);

    generateTable(link);
    $("table").tablesorter({sortlist: [[3,1]]});
});

// data structure: DOI Title Author Conference Link
function generateTable(url){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:'./src/conferencelist.php',
        async:false,
        data:{
            link: url,
        },
        success: function(returned){
            articleTitle = returned;
        },
        error: function(){
            console.log("ERROR");
        }
    });

    document.getElementById('conference').innerHTML = conferenceTitle;

    var tbody = document.getElementById("myTableBody");
    console.log(articleTitle);
    for(var i = 0; i < articleTitle.length; i++){
        var tr = document.createElement('tr');
        var index = document.createElement('td');
        index.textContent = i;
        tr.appendChild(index);
        var title = document.createElement('td');
        title.textContent = articleTitle[i];
        tr.appendChild(title);
        tbody.appendChild(tr);
    }
}