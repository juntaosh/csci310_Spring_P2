var frequencyReturn=0;
var isExpanded = false;
var ExpandedRow = -1;
var Articles = new Array();
var index2Abstract = new Array();
var index2Bibtex = new Array();
var index2Link = new Array();
var searchword;
var numpapers = 0;

$(document).ready(function() {
    var data = location.search;
    data = data.replace('?', '');
    var items = data.split("&");
    var word = items[0].split("=")[1];
    searchword=word;
    console.log(searchword);
    numpapers = items[1].split("=")[1];
    document.getElementById('word').innerHTML = word.toUpperCase();

    var worddata = localStorage.getItem('wordData');
    var tmp = JSON.parse(worddata);
    console.log(tmp);
    generateTable(tmp, word);
    $("table").tablesorter({sortList: [[3,1]]});

    $("#pdfBtn").click(function(e){
        $('#myTable').tableExport({type:'pdf',
                           jspdf: {orientation: 'l',
                                   format: 'a3',
                                   margins: {left:10, right:10, top:20, bottom:20},
                                   autotable: {styles: {fillColor: 'inherit', 
                                                        textColor: 'inherit'},
                                               tableWidth: 'auto'}
                                  }
                           });
    });
    $("#textBtn").click(function(e){
        $('#myTable').tableExport({type:'txt',});
    });
    $('#generateBtn').click(function(){
        regenerate();
    });
});

// data structure: DOI Title Author Conference Link
function generateTable(data, word){
    var tbody = document.getElementById("myTableBody");
    var Articles = data.articles;
    frequencyReturn = 0;
    for(var i = 0; i < Articles.length; i++){
        var tr = document.createElement('tr');
        tr.setAttribute('id', "tr"+i);

        var checkbox = document.createElement('td');
        var check = document.createElement('input');
        check.setAttribute("id", Articles[i].DOI);
        check.setAttribute("type", "checkbox");
        checkbox.appendChild(check);
        tr.appendChild(checkbox);

        var Title = document.createElement('td');
        Title.textContent = Articles[i].Title;
        var para = "click(this," + i + ")";
        Title.setAttribute('name', i);
        Title.onclick = function(){click(this)};
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
        index2Abstract.push(Articles[i].Abs);
        index2Bibtex.push(Articles[i].Bibtex);
        index2Link.push(Articles[i].Link);
    }
}


function click(element){
    var i = element.getAttribute("name");
    console.log(i);
    var index = element.parentNode.rowIndex;
    var table = document.getElementById("myTable");
    console.log(index);
    console.log(ExpandedRow);
    if(isExpanded && index == ExpandedRow-1){// if click on the same item second time => close it
        console.log("try to close");
        table.deleteRow(ExpandedRow);
        isExpanded = false;
        ExpandedRow = -1;
        // TODO enable the sort function
        enableHeader();
    } else if(isExpanded && index != ExpandedRow){// if click on the other item while opening =>open the index one then close the previous one
        if(index < ExpandedRow-1){
            table.deleteRow(ExpandedRow);
            isExpanded = true;
            ExpandedRow = index+1;
            var row = table.insertRow(ExpandedRow);
            extend(row, i);
        } else if(index > ExpandedRow) {
            var row = table.insertRow(index+1);
            extend(row, i);
            table.deleteRow(ExpandedRow);
            isExpanded = true;
            ExpandedRow = index;
        }
        // TODO disable the sort function
        disableHeader();
    } else {
        console.log("start");
        var row = table.insertRow(index+1);
        extend(row, i);
        ExpandedRow = index+1;
        isExpanded = true;
        console.log(ExpandedRow);
        console.log(table.rows.length);
        disableHeader();
    }
}

function extend(row, i){
    var abstract = document.createElement('td');
    abstract.setAttribute("colspan", 4);
    index2Abstract[i].replace("<br/>", "");
    abstract.textContent = "Abstract : " + index2Abstract[i];
    var inner = abstract.innerHTML;

    var lowertext = inner;
    lowertext = lowertext.toLowerCase();
    searchword = searchword.toLowerCase();
    var index = lowertext.indexOf(searchword, 0);
    var offset = 0;
    var startpoint = 0;
    console.log(inner);
    while(index != -1){
        console.log(index);
        inner = inner.substring(0,index+offset) + "<span style='background-color:Gold'>" + inner.substring(index+offset,index+searchword.length+offset) + "</span>" + inner.substring(index + searchword.length+offset);
        offset += 43;
        index = lowertext.indexOf(searchword, index+searchword.length);
        startpoint = index;
    }
    abstract.innerHTML = inner;
    row.appendChild(abstract);
    
    var Bibtex = document.createElement('td');
    var a = document.createElement('a');
    a.setAttribute("href", index2Bibtex[i]);
    a.textContent = "Bibtex";
    Bibtex.appendChild(a);
    row.appendChild(Bibtex);

    var Download = document.createElement('td');
    var b = document.createElement('a');
    b.textContent = "H_PDF";
    console.log("hpdf");
    console.log(i);
    b.onclick = function(){downloadHighlight(i)}
    Download.appendChild(b);
    row.appendChild(Download);
}

function downloadHighlight(i){
    console.log(index2Link[i]);
    console.log(searchword);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:'./src/pdfHighlighter.php',
        async:false,
        data:{
            path: index2Link[i],
            word: searchword
        },
        success: function(){
            console.log("Highlighted");
            var dl = document.createElement('a');
            dl.setAttribute("href", "../tmp/output.pdf");
            dl.setAttribute("download", searchword + ".pdf");
            dl.click();
        },
        error: function(){
            console.log("ERROR");
        }
    });

}

function disableHeader(){
    document.getElementById('check').setAttribute("data-sorter", false);
    document.getElementById('title').setAttribute("data-sorter", false);
    document.getElementById('author').setAttribute("data-sorter", false);
    document.getElementById('freq').setAttribute("data-sorter", false);
    document.getElementById('conf').setAttribute("data-sorter", false);
    document.getElementById('dld').setAttribute("data-sorter", false);
}

function enableHeader(){
    document.getElementById('check').setAttribute("data-sorter", true);
    document.getElementById('title').setAttribute("data-sorter", true);
    document.getElementById('author').setAttribute("data-sorter", true);
    document.getElementById('freq').setAttribute("data-sorter", true);
    document.getElementById('conf').setAttribute("data-sorter", true);
    document.getElementById('dld').setAttribute("data-sorter", true);
}

// loop through each td checkbox, if it is checked, put the corresponding Articles into chosen
// And then store in local storage for later use
// And then open up the regenerate window
function regenerate(){
    var worddata = localStorage.getItem('wordData');
    var tmp = JSON.parse(worddata);
    console.log(tmp);
    var Articles = tmp.articles;
    var td = document.getElementsByTagName('input');
    var chosen = Array();
    for(var i = 0; i < td.length; i++){
        if(td[i].getAttribute("type") == "checkbox"){
            if(td[i].checked){
                for(var j = 0; j < Articles.length; j++){
                    if(td[i].id == Articles[j].DOI){
                        chosen.push(Articles[j]);
                    }
                }
            }
        }
    }
    console.log(chosen);
    var jsonObj = JSON.stringify(chosen);
    localStorage.setItem('regenerate', jsonObj);
    window.close();
    window.open("regenerate.html");
}