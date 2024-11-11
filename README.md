# ReviewMate

**ReviewMate** is an engaging movie review website designed to give users the ultimate movie and digital media rating experience. Users can browse an extensive collection of movies, TV series, documentaries, video games, music albums, and books, share personal reviews, and track their media journey with customized profiles.

## Features

### 🔍 Explore a Rich Media Library
- **Browse without Logging In:** Discover movies and media collections before creating an account.
- **Customizable Search:** Filter by recent updates, highest ratings, genre, actors, or cast members to find what you’re in the mood for.

### 👤 User Profiles
- **Profile Creation:** Sign up to unlock profile features and personalize your experience.
- **Lists & Tracking:** Keep track of movies and media with lists like:
  - **Movies Watched**
  - **Movies Reviewed**
  - **Watchlist** (for items marked as "to watch")
  
### 📑 Movie & Media Reviews
- **Write Reviews:** Share your thoughts and opinions on your favorite movies, series, or albums.
- **User Ratings:** Add your own ratings to build a dynamic community rating system.
- **Detailed Showcases:** View movie details including cast, crew, and similar media recommendations.

## Pages Overview

| Page             | Description                                                               |
|------------------|---------------------------------------------------------------------------|
| **Login/Logout**  | User authentication and session management.                               |
| **Registration**  | Sign up to start your ReviewMate journey.                                 |
| **Movie Showcase**| Browse a curated collection of movies and media.                          |
| **Movie Details** | View specific movie information, reviews, cast, and related media.        |
| **Movie Search**  | Advanced search options to help you discover new media.                   |
| **Profile**       | Personalized page with user information, lists, and activity logs.        |

## Database Structure

The ReviewMate database is designed to support a range of features and activities across the platform. Below are the tables included:

| Table               | Purpose                                                                |
|---------------------|------------------------------------------------------------------------|
| `actors`            | Stores information about actors.                                      |
| `directors`         | Stores details about directors.                                       |
| `movies`            | Main table for movie and media information.                           |
| `movies_reviewed`   | Tracks movies reviewed by users.                                      |
| `movies_watched`    | Tracks movies watched by users.                                       |
| `movie_actors`      | Links actors to movies.                                               |
| `movie_directors`   | Links directors to movies.                                            |
| `reviews`           | Contains user reviews and ratings for movies and media.               |
| `userinfo`          | Stores user-specific information.                                     |
| `userlogin`         | Manages user login credentials.                                       |
| `watchlist`         | Tracks items users want to watch later.                               |

## Getting Started

1. **Clone the Repository:**
   ```bash

    git clone https://github.com/ReD9541/ReviewMate.git
   ```

2. **Set Up Database:**
   - Configure the database with the provided tables to enable ReviewMate’s features.
   - OR uncomment the database login from the db_connect.php to use my online database

3. **Run the Application:**
   - Start your local server and navigate to the main page.

4. **Explore!** Create an account, browse the library, add to your watchlist, and share your reviews!

## Tech Stack

- **Backend:** PHP (for server-side logic and database interaction)
- **Frontend:** HTML, CSS, JavaScript (for dynamic user experience)
- **Database:** Relational database to manage user data and media records

