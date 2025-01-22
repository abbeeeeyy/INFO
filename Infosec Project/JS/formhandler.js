function viewMovie(movieId) { 
    // Redirect to the movie details page with the movie ID as a query parameter
    window.location.href = 'ABOUTMOVIE.php?id=' + movieId;
}

// Function to get the query parameter value
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
} 

// Function to display movie details
function displayMovieDetails(movieId) {
    // Dummy movie data (replace with actual data or a PHP call to fetch data)
    const movieData = {
        '1': { title: 'Movie 1', description: 'Description for Movie 1' },
        '2': { title: 'Movie 2', description: 'Description for Movie 2' },
        '3': { title: 'Movie 3', description: 'Description for Movie 3' },
    };
    
    // Get the movie details element
    const movieDetails = document.getElementById('movieDetails');
    
    // Populate the movie details based on the movieId
    if (movieData[movieId]) {
        movieDetails.innerHTML = `
            <h2>${movieData[movieId].title}</h2>
            <p>${movieData[movieId].description}</p>
            `;
        }
    else {
        movieDetails.innerHTML = '<p>Movie not found</p>';
    }
} 
// Get the movie ID from the query parameter and display the details
const movieId = getQueryParam('id'); displayMovieDetails(movieId);