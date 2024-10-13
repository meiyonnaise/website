const searchForPost = () => {
    
    const search = document.getElementById('search');
    const course = window.location.pathname.split('/')[3];
    let allPosts;

    // Store all of the post information into allPosts.
    let requestPosts = new XMLHttpRequest();
    requestPosts.open('GET', `https://infs3202-5b41c573.uqcloud.net/demo/course/${course}/posts`);
    requestPosts.responseType = 'json';
    requestPosts.onload = function() {
        allPosts = requestPosts.response;
        console.log(allPosts);


    // Autocompletion.
    search.addEventListener('input', function(e) {
        let input = e.target.value;
        let suggestions = document.getElementById('suggestions');
        let suggestionsHTML = "";
        suggestions.innerHTML = '';

        if (input.length === 0) {
            return;
        }

        let matches = allPosts.filter(function(post) {
            return post.title.toLowerCase().includes(input.toLowerCase());
        });
        console.log(matches);

        matches.forEach(function(post) {
            suggestionsHTML += `<a href=/demo/course/${course}/posts/${post.id} class="btn input-block-level form-control btn-info"> ${post.title} </a><br>`;
        });
    
        suggestions.innerHTML = suggestionsHTML;

    });

    }
    requestPosts.send();

}

document.addEventListener("DOMContentLoaded", searchForPost);