var returndata = [];
var numberofpaper =0;

$(document).ready(function() {
	var worddata = localStorage.getItem("regenerate");
	var tmp = JSON.parse(worddata);
	console.log("asdfadfadfadfa");

	regenerate(tmp);
});

// use link as the parameter
function regenerate(data){
	var Articles = Array();
	numberofpaper = data.length;
	for(var i = 0 ; i < data.length; i++){
		Articles.push(data[i]);
	}
	console.log(Articles);
	var link2Articles = new Map();
	var chosen = "";
	for(var i = 0; i < Articles.length; i++){
		chosen = chosen + Articles[i].Link + "|";
		link2Articles.set(Articles[i].Link, Articles[i]);
		console.log(Articles[i]);
	}
	console.log(link2Articles);
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'./src/regenerate.php',
		async:false,
		data:{
			files: chosen
		},
		success: function(returned){
			console.log(returned);
			//returndata = returned;
			var wordlist = [];
			var length = returned.length > 250 ? 250 : returned.length;
			for(var i = 0; i < length; i++){
				wordlist.push([returned[i].word, (Math.sqrt(returned[i].count))*8]);
				var arts = returned[i].articles.split("|");
				//console.log(arts);
				var array = Array();
				for(var j = 0; j < arts.length; j++){
					console.log(arts[j]);
					array.push(link2Articles.get(arts[j]));
					console.log(array);
				}
				var map = {word : returned[i].word, count : returned[i].count, articles : array};
				console.log(map);
				//link2Articles.get(returned[i].articles)};
				//var map = new Map();
				//map.set("word", returned[i].word);
				//map.set("count", returned[i].count);
				//map.set("articles", link2Articles.get(returned[i].word));
				returndata.push(map);
			};
			generateWordCloud(wordlist);
		},
		error: function(){
			console.log("ERROR");
		}
	});
}

// generateWordCloud by given wordlist[[word,value],[]...]
function generateWordCloud(wordlist){
	var options = {};
	options.list=wordlist;
	options.gridSize=Math.round(16 * $('#mycanvas').width() / 1024);
	options.weigtfactor=function(size){
		return Math.pow(size, 2.3) * $('#mycanvas').width() / 1024;
	};
	options.fontFamily='Times, serif';
	options.color='#000000';
	options.rotateRatio=0;
	options.rotationSteps=1;
	options.backgroundColor='Snow';
	options.drawOufofBound=false;
	options.click=function(item, dimension, event){
		storage(item[0]);
		//window.close();
		window.open("list_page.html?word="+item[0]+"&papers="+numberofpaper);
	};
	WordCloud(document.getElementById('mycanvas'), options);
}

jQuery(function($) {
	$('#downBtn').on('click', function save(evt) {
		var $canvas = document.getElementById('mycanvas');
		var url = $canvas.toDataURL();
		if ('download' in document.createElement('a')) {
			this.href = url;
		} else {
			evt.preventDefault();
			alert('Please right click and choose "Save As..." to save the generated image.');
			window.open(url, '_blank', 'width=500,height=300,menubar=yes');
		}
	});
});

function storage(word){
	console.log(word);
	console.log(returndata);
	for(var i = 0; i < returndata.length; i++){
		console.log(returndata[i].word);
		if(returndata[i].word == word){
			console.log(word);
			console.log(returndata[i]);
			var jsonObj = JSON.stringify(returndata[i]);
			localStorage.setItem('wordData', jsonObj);
			break;
		}
	}
}
