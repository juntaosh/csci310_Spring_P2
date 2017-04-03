var returndata= [];
// search
function search(){
	var searchword = document.getElementById("searchWord").value;
	var paperNumber = document.getElementById("numberofpaper").value;
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'search.php',
		data:{
			word: searchword,
			number: paperNumber
		},
		success: function(returned){
			console.log("success");
			console.log(returned);
			returndata = returned;
			var wordlist = [];
			var length = returned.length > 250 ? 250 : returned.length;
			for(var i = 0; i < length; i++){
				wordlist.push([returned[i].word, (Math.sqrt(returned[i].count))*8]);
			};
			console.log(wordlist);
			if(wordlist){
				generateWordCloud(wordlist);
			} else {
				//Generate No Result Word Cloud
				var wordlist = [["No Searching Result", 80]];
				generateWordCloud(wordlist);
			}
		},
		error: function(){
			console.log("ERROR");
		}
	});

}

function storage(word){
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
		console.log(item[0]);
		storage(item[0]);
		window.open("list_page.html?word="+item[0]);
	};
	WordCloud(document.getElementById('mycanvas'), options);
}
