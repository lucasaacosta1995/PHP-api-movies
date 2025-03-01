<?php

namespace MovieAPI;

class Movies {
    private static $bearerToken = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3Y2YyMWI1ZGZiZTNkOTRiMGQ1ZjU4MTY5NGFjZDBkNyIsIm5iZiI6MTc0MDg1NjE1OC4yNjQ5OTk5LCJzdWIiOiI2N2MzNWI1ZTM2MGNhOWQxMmM2NmJjNjgiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.awLI5Yre4Em60ZRE7QkH0Mj64GOLGzaC0BVEE3RJ8Wg";
    private static $baseUrl = "https://api.themoviedb.org/3";

    public static function getPopularMovies($page = 1) {
        $url = self::$baseUrl . "/movie/popular?page={$page}";
        return self::fetchData($url);
    }

    public static function getMovieDetails($movieId) {
        $url = self::$baseUrl . "/movie/{$movieId}";
        return self::fetchData($url);
    }

    public static function getPopularTVShows($page = 1) {
        $url = self::$baseUrl . "/discover/tv?include_adult=false&language=en-US&page={$page}&sort_by=popularity.desc";
        return self::fetchData($url);
    }

    private static function fetchData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . self::$bearerToken,
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error en cURL: ' . curl_error($ch);
        }
        curl_close($ch);
        
        return json_decode($result, true) ?? false;
    }
}

// Ejemplo de uso
echo "Películas populares: ";
print_r(Movies::getPopularMovies());

echo "Series de TV populares: ";
print_r(Movies::getPopularTVShows());
