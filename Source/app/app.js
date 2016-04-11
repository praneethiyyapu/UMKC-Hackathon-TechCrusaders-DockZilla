'use strict';

// Declare app level module which depends on views, and components
angular.module('myApp', [])


    .controller('View1Ctrl', function ($scope, $http) {
      $scope.venueList = new Array();
      $scope.mostRecentReview;
      $scope.getVenues = function () {
        var placeEntered = document.getElementById("txt_CompName").value;

        if (placeEntered != null && placeEntered != "" ) {
          document.getElementById('div_ReviewList').style.display = 'none';
          //This is the API that gives the list of venues based on the place and search query.
          var handler = $http.get("https://dictionary.yandex.net/api/v1/dicservice.json/lookup?" +
              "key=dict.1.1.20160202T025303Z.884393d1bc654f0c.e6ec9d84d2be290482388dda13e526a807092c05&lang=en-en&text="+placeEntered);
          handler.success(function (data) {

              if (data != null && data.def[0] != null && data.def[0].tr != undefined && data.def[0].tr != null) {
                  for (var i = 0; i < 5; i++) {
                      $scope.venueList[i] = {
                          "text": data.def[0].tr[i].text
                      };
                  }
              }

          })
          handler.error(function (data) {
            alert("There was some error processing your request. Please try after some time.");
          });
        }
      }
      $scope.getReviews = function (venueSelected) {
        if (venueSelected != null) {
          //This is the API call being made to get the reviews(tips) for the selected place or venue.
              //This is the Alchemy API for getting the sentiment of the most recent review for a place.
              var callback = $http.get("http://gateway-a.watsonplatform.net/calls/text/TextGetTextSentiment" +
                  "?apikey=d0e7bf68cdda677938e6c186eaf2b755ef737cd8" +
                  "&outputMode=json&text=" + venueSelected.text);
              callback.success(function (data) {
                if(data!=null && data.docSentiment!=null)
                {
                  $scope.ReviewWithSentiment = {
                      "sentiment":data.docSentiment.type,
                      "score":data.docSentiment.score
                  };
                    document.getElementById('div_ReviewList').style.display = 'block';
                }
              })
            }
          callback.error(function (result) {
            alert("There was some error processing your request. Please try after some time.")
          })
        }

    });
