<!doctype html>
<html>
<head>
    <title>Dockzilla</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
   
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<style>

	html,body{
		height:100%;		
	}
	.container{
		background-image:url("bg.jpg");
		width:100%;
		height:100%;
		background-size:cover;
		background-position: center;
		padding-top: 25px;
	}


	.center{
		text-align: center;

	}

	.white{
		color:white;
	}
	p{
		padding-top: 15px;
		padding-bottom:15px;
	}

	button{
		margin-top: 20px;
		margin-bottom: 20px;
	}

	.alert{
		margin-top: 20px;
		display:none;
	
	}
	.whiteBackground{
		background-color:white;
		padding:20px;
		border-radius:20px;
	}
	button{
		margin-top: 20px;
		margin-bottom: 20px;
	}

	.alert{
		margin-top: 20px;
		display:none;
	
	}
	.whiteBackground{
		background-color:white;
		padding:20px;
		border-radius:20px;
	}
	#btnShow{
		position:relative;
		left:230px;
		bottom:48px;
	}
	#fUpload{
		position:relative;
		right:15px;
	}
	#ulList{
		display:none;
	}
	#imgUpload{
		position:relative;
		left:250px;
		bottom:40px;
		padding:0px;
		margin:0px;
		border-radius:0px;
	}
	</style>

 </head>

<body>


	<div class = "container">

				<div class = "col-md-6 col-md-offset-3 center whiteBackground">
					<h1 class = "center ">Want to know what's in your document?</h1>
					<p class = "lead center ">Upload any file from your local machine</p>
					<input id="fUpload" class = "btn btn-success btn-lg type="button multiple type="file"/>
					<ul id="ulList"></ul>
					<div id="d1"></div>
					<input id="btnShow" class = "btn btn-success btn-lg type="button" value="Upload"/><br/>
					<p id="imgUpload"></p>
				<form>
					<div class = "form-group">
						
					</div>
				<button id = "findMyPostcode" class = "btn btn-success btn-lg "> Find what's in my doc</button>
				</form>

				
				<div id = "forecast"class = "alert alert-success">Success!</div>
				<div id = "success"class = "alert alert-success">Success!</div>
				<div id ="positive" class="alert alert-success">
				<strong>Positive!</strong> The overall sentiment of the document is positive.
				</div>
				
				<div id="neutral" class="alert alert-info">
				<strong>Neutral!</strong> The overall sentiment of the document is neutral.
				</div>
				<div id="negative"class="alert alert-danger">
				<strong>Negative!</strong> The overall sentiment of the document is negative.
				</div>
				</div>

			


			</div> 
	</div>
	
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>

$(document).ready(function(){
$("#btnShow").on('click', function () {
    $("#ulList").empty();
    var fp = $("#fUpload");
    var lg = fp[0]
    .files.length; // get length
    var items = fp[0].files;
    var fragment = "";
    if (lg > 0) {
        for (var i = 0; i < lg; i++) {
            var fileName = items[i].name; // get file name
            var fileSize = items[i].size; // get file size 
            var fileType = items[i].type; // get file type
          // append li to UL tag to display File info
         fragment += "<li>" + fileName + " " + fileSize + " bytes. Type :" + fileType + "</li>";
        }
       $("#ulList").append(fileName);
	   $("#imgUpload").html("Document uploaded!");
    }
});
});

$("#findMyPostcode").click(function(event){
        event.preventDefault();
		var searchThis = document.getElementById("ulList").innerHTML;
		var str1 = "jpg";
		var str2 ="mp4";
		var str3="txt";
		if (searchThis.search(str1)!=-1){
        $.ajax({
                type: "GET",
                url: "https://gateway-a.watsonplatform.net/calls/url/URLGetRankedImageKeywords?url=http://698897bf.ngrok.io/documentOrganize/"+searchThis+"&outputMode=json&apikey=d3d086756895eb2de56d0e8211c4018d24cf15f8" ,
                dataType: "json",
                success: processJSON3
              });
		$.ajax({
                type: "GET",
                url: "https://gateway-a.watsonplatform.net/calls/url/URLGetRankedImageFaceTags?url=http://698897bf.ngrok.io/documentOrganize/"+searchThis+"&outputMode=json&apikey=d3d086756895eb2de56d0e8211c4018d24cf15f8" ,
                dataType: "json",
                success: processJSON4
              });
        }
		else if (searchThis.search(str2)!=-1){
		//else{
        $.ajax({
                type: "GET",
                //url: "https://gateway-a.watsonplatform.net/calls/url/URLGetRankedImageKeywords?url=http://5a71b4f9.ngrok.io/documentOrganize/"+searchThis+"&outputMode=xml&apikey=d3d086756895eb2de56d0e8211c4018d24cf15f8" ,
				url: "https://api.clarifai.com/v1/tag?url=http://698897bf.ngrok.io/documentOrganize/"+searchThis+"&access_token=C6pXNfndvQgmZCQraRPdAE76swzKQa",
                dataType: "json",
                success: processJSON
              });
        }
		else if (searchThis.search(str3)!=-1){
        $.ajax({
                type: "GET",
                url: "http://gateway-a.watsonplatform.net/calls/url/URLGetTextSentiment?url=http://698897bf.ngrok.io/documentOrganize/"+searchThis+"&outputMode=json&apikey=d3d086756895eb2de56d0e8211c4018d24cf15f8" ,
                dataType: "json",
                success: processJSON1
              });
        }
			

        function processJSON3(data) {
	                    $("#forecast").fadeIn();
						$("#forecast").html("The document contains image of "+data.imageKeywords[0].text);
        }
		
				  

        function processJSON(data) {
						
	                    $("#forecast").fadeIn();
						$("#forecast").html("The video contains information about "+((data.results[0].result.tag.classes[0])[0])+", "+((data.results[0].result.tag.classes[0])[1])+", "+((data.results[0].result.tag.classes[0])[2])+", "+((data.results[0].result.tag.classes[0])[3])+", "+((data.results[0].result.tag.classes[0])[4])+", "+((data.results[0].result.tag.classes[0])[5])+", "+((data.results[0].result.tag.classes[0])[6])+", "+((data.results[0].result.tag.classes[0])[7]) );
						
        }
		function processJSON1(data) {
	                    $("#forecast").fadeIn();
						$("#forecast").html("The document is in "+"<strong>"+data.language+"</strong>"+" language");
						if(data.docSentiment.type=="positive"){
						$("#positive").fadeIn();
							
						}
						else if(data.docSentiment.type=="negative"){
						$("#negative").fadeIn();
							
						}
						else if(data.docSentiment.type=="neutral"){
						$("#neutral").fadeIn();
							
						}
						
        }
		function processJSON4(data) {
						if((data.imageFaces[0]).identity.disambiguated.name!=""){
	                    $("#success").fadeIn();
						$("#success").html("The person has been identified as "+"<strong>"+(data.imageFaces[0]).identity.name+"</strong>" );
						}
						
        }
		
		
   });	

    
   
   

</script>

</body>
</html>