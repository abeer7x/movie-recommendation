#Movie Recommendation System

This project is a Netflix Movie Recommendation System built with Laravel.
It provides movie recommendations using two main algorithms:

##Apriori Algorithm

Analyzes relationships between movie genres.

Generates association rules with support and confidence to recommend movies similar to what a user has watched.

##KMeans Algorithm

Clusters movies based on numeric features like release year, rating, and duration.

KMeans recommendations are based on movies within the same cluster and stored in the database.

Project Features

Reads movie data from a CSV file.

Calculates recommendations and stores them in the Recommendations table.

Provides an API to fetch movies and recommendations.
