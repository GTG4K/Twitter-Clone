jQuery(function() { 
    
    $("#search").on('input', function(){
        $.ajax({
            url: 'search_result',
            type: 'GET',
            data: {search: $(this).val()},
            success: function(response){
                $('#search_result').empty()

                if(response.search_users != null){
                    $('#search_result').append(
                        "<a class='search_result_container' href=https://tinder.com>\
                        <h1>🔥 How about you go search for some bitches instead 🔥</h1>\
                        </a>"
                    )
                }

                $.each(response.search_users, function(key,item){
                    $('#search_result').append(
                        "<a class='search_result_container' href=profile/"+ item.id+ ">\
                        <div class='user'>\
                            <img id='search_user_pfp' src=" + item.profile_picture +" alt=''/>\
                            <div class='user_details'>\
                                <h2 id='search_user_name'>" + item.name + "</h2>\
                                <p id='search_user_bio'>" + item.bio + "</p>\
                            </div>\
                        </div>\
                        </a>"
                    );
                })
            }
        })
    });
});