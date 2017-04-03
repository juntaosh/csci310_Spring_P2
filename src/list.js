var frequencyReturn=0;
$(document).ready(function() {
    var data = location.search;
    data = data.replace('?', '');
    var items = data.split("&");
    var word = items[0].split("=")[1];
    console.log(word);
    document.getElementById('word').innerHTML = word.toUpperCase();

    var worddata = localStorage.getItem('wordData');
    var tmp = JSON.parse(worddata);
    console.log(tmp);
    generateTable(tmp, word);
    $("table").tablesorter();
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
        Author.textContent = Articles[i].Author;
        tr.appendChild(Author);
        
        var Frequency = document.createElement('td');
        $.ajax({
        type: 'POST',
        dataType: 'json',
        url:'wordFrequency.php',
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
        Conference.textContent = Articles[i].Conference;
        tr.appendChild(Conference);
        
        var Path = document.createElement('td');
        var a = document.createElement('a');
        a.textContent = "PDF";
        var address = "http://dl.acm.org/" + Articles[i].Link;
        a.setAttribute("href", address);
        Path.appendChild(a);
        tr.appendChild(Path);
        
        tbody.appendChild(tr);
    }
}