
// Get All Albums by the artist id
function search(){
	var searchword = document.getElementById("searchWord").value;
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'search.php',
		data:{
			word: searchword
		},
		//async:
		success: function(returned){
			console.log("success");
			console.log(searchword);
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
	options.backgroundColor='#808080';
	options.drawOufofBound=false;
	options.click=function(item, dimension, event){
		window.open("Song_list.html?word="+item[0] + "&artist_id=" + rId);
	};
	WordCloud(document.getElementById('mycanvas'), options);
}