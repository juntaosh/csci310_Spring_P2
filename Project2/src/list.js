var frequencyReturn=0;
var numpapers = 0;
$(document).ready(function() {
    var data = location.search;
    data = data.replace('?', '');
    var items = data.split("&");
    var word = items[0].split("=")[1];
    numpapers = items[1].split("=")[1];
    console.log(word);
    document.getElementById('word').innerHTML = word.toUpperCase();

    var worddata = localStorage.getItem('wordData');
    var tmp = JSON.parse(worddata);
    console.log(tmp);
    generateTable(tmp, word);
    $("table").tablesorter({sortlist: [[3,1]]});
});

// data structure: DOI Title Author Conference Link
function generateTable(data, word){
    var tbody = document.getElementById("myTableBody");
    console.log(data.articles);
    var Articles = data.articles;
    frequencyReturn = 0;
    for(var i = 0; i < Articles.length; i++){
        var tr = document.createElement('tr');

        var checkbox = document.createElement('td');
        var check = document.createElement('input');
        check.setAttribute("id", Articles[i].DOI);
        check.setAttribute("type", "checkbox");
        checkbox.appendChild(check);
        tr.appendChild(checkbox);

        var Title = document.createElement('td');
        Title.textContent = Articles[i].Title;
        tr.appendChild(Title);

        var Author = document.createElement('td');
        var c = document.createElement('a');
        c.textContent = Articles[i].Author;
        var outURL = "index.html?author=";
        outURL+=Articles[i].Author;
        outURL+="&paper=";
        outURL+=numpapers;
        c.setAttribute("href",outURL);
        Author.appendChild(c);
        tr.appendChild(Author);
        
        console.log(Articles[i].Link);
        var Frequency = document.createElement('td');
        $.ajax({
        type: 'POST',
        dataType: 'json',
        url:'./src/wordFrequency.php',
        async:false,
        data:{
            word: word,
            path: Articles[i].Link
        },
        success: function(returned){
            frequencyReturn = returned;
        },
        error: function(){
            console.log("ERROR");
        }
        });

        Frequency.textContent = frequencyReturn;
        console.log(Frequency.textContent);
        tr.appendChild(Frequency);

        var Conference = document.createElement('td');
        var b = document.createElement('a');
        b.textContent = Articles[i].Conference;
        var addr = "conferencelist.html?" + Articles[i].ConferenceLink + "&title=" + Articles[i].Conference;
        console.log(addr);
        b.setAttribute("href", addr);
        Conference.appendChild(b);
        tr.appendChild(Conference);
        
        var Path = document.createElement('td');
        var a = document.createElement('a');
        a.textContent = "PDF";
        var address = Articles[i].Link;
        a.setAttribute("href", address);
        a.setAttribute("download", Articles[i].Title);
        Path.appendChild(a);
        tr.appendChild(Path);
        
        tbody.appendChild(tr);
    }
}