jQuery(document).ready(function($){
    console.log('testing football team')
    //hide some forms..
    $('#new_football_team_form').hide()
    $('#new_football_team_league_form').hide()
    var soccerTableDiv = $('.soccer-team-table')
   

   // adding the football team 
   $('#NewTeamForm').submit(function(evt){
    evt.preventDefault()

    // console.log('uploaded file', evt.target.files)
  
    var teamName = $('#team_name').val(),
        nickName = $('#team_nickname').val(),
        teamHistory = $('#team_history').val(),
        teamLeague = $('#team_league').val(),
        security = $('#security').val(),
        packagephoto_data = $('#packagephoto').prop('files')[0];

        
      console.log('file name', packagephoto_data)
       
      var formData = new FormData();
      formData.append('action', 'register_football_team_action')
      formData.append('teamName', teamName) 
      formData.append('nickName', nickName)
      formData.append('teamHistory', teamHistory)
      formData.append('teamLeague', teamLeague)
      formData.append('security', security )
      formData.append('packagephoto_name', packagephoto_data);


      $.ajax({
            url:siteData.ajaxurl,
            type:"POST",
            processData: false, //// Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            data: formData,
            success : function( response ){
                  if (response.success == true) {
                      $('#new_football_team_form').hide()
                      let tableRow = "<tr><td>" + "6" + "</td><td>" + teamName + "</td><td>" + nickName + "</td><td>" + teamHistory + "</td><td>" + teamLeague + "</td><td><button class='btn btn-info btn-edit ms-2 mt-2'>Edit</button><button class='btn btn-danger btn-delete ms-2 mt-2'>Delete</button></td></tr>"
                      soccerTableDiv.show()
                      soccerTableDiv.append(tableRow)
                  }else{
                     alert('Failed to add the football team')
                  }
            },
            error: function(response){
              console.log('error', response)
            }
     });


  
    })


    $('.add-team').click(function(e){
        e.preventDefault()
        $('#new_football_team_form').show()
        //$('.soccer-team-table').hide()
        soccerTableDiv.hide();
    })

    /// for the football team league
    // adding the football team 
   $('#NewFootballLeagueForm').submit(function(evt){
      evt.preventDefault()
  
      var leagueName = $('#league_name').val(),
          description = $('#description').val()

        //queryParams = getUrlParams(window.location.search)
  
        var formData = {
          'action': 'register_football_league_action',
          'leagueName': leagueName,
          'description': description
        }
  
        // console.log('let see form data', formData)

        //$('.soccer-league-table').show()
  
      //$.post('/wp-admin/admin-ajax.php', formData, function(response){ //404 Not Found
      $.post(siteData.ajaxurl, formData, function(response){
              console.log('reponse team league', response)
             if (response.success == true) {
                  $('#new_football_team_league_form').hide()
                  let tableRow = "<tr><td>" + "6" + "</td><td>" + leagueName + "</td><td>" + description +  "</td><td><button class='btn btn-info btn-edit ms-2 mt-2'>Edit</button><button class='btn btn-danger btn-delete ms-2 mt-2'>Delete</button></td></tr>"
                  $('.soccer-league-table').append(tableRow)
             } else {
                 alert('failed to add the football league')
             }
      });
  
    })

    $('.add-league').click(function(e){
       $('#new_football_team_league_form').show()
    })

    //search form..
    $('#search_team_form').submit(function(evt){

        evt.preventDefault()
  
        var searchInput = $('#keyword').val()

        //queryParams = getUrlParams(window.location.search)
  
        var formData = {
          'action': 'search_team_action',
          'searchInput': searchInput
        }
  
        console.log('search form data', formData)
  
      //$.post('/wp-admin/admin-ajax.php', formData, function(response){ //404 Not Found
        $.post(siteData.ajaxurl, formData, function(response){
              console.log('reponse team league', response)
             if (response.success == true) {
                   $(".leaderboard__profiles").empty();
                  let sportList = JSON.parse(response.data.message)
                  if (sportList.length > 0) {
                      sportList.forEach(sport=>{
                        let sportItem = '<article class="leaderboard__profile">' + 
                                         '<img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/cc/Chelsea_FC.svg/1200px-Chelsea_FC.svg.png" alt="sports team" class="leaderboard__picture">' + 
                                          '<span class="leaderboard__name">' + sport.team_name + '</span>' +
                                          '<span class="leaderboard__history">' + sport.team_history + '</span>' +
                                          // '<span class="leaderboard__value">35.7<span>B</span></span>' +
                                          '</article>' ;
                        $('.leaderboard__profiles').append(sportItem)
                      })
                  } else {
                    $('.leaderboard__profiles').append('<p>No search results found for football team</p>')
                  }
             } else {
                 alert('failed to search for the football teams')
             }
      });
  
    })

})
