import json
import requests
from PIL import Image
from io import BytesIO
import os
import re

API_KEY = "190f106245b7b87934d6f3a576fb7889"

SEARCH_URL = "https://api.themoviedb.org/3/search/movie"
DETAILS_URL = "https://api.themoviedb.org/3/movie/{}"
POSTER_BASE = "https://image.tmdb.org/t/p/original"

JSON_FILE = "movies.json"
POSTER_DIR = "posters"

os.makedirs(POSTER_DIR, exist_ok=True)


def safe_filename(title):
    return re.sub(r'[^a-z0-9]+', '_', title.lower()).strip('_')


def find_movie(title, year=None):
    params = {
        "api_key": API_KEY,
        "query": title
    }

    if year:
        params["year"] = year

    r = requests.get(SEARCH_URL, params=params)
    data = r.json()

    if not data["results"]:
        return None

    return data["results"][0]


def download_webp(url, filename):
    r = requests.get(url)
    img = Image.open(BytesIO(r.content))
    img.save(filename, "WEBP", quality=90)


with open(JSON_FILE) as f:
    movies = json.load(f)


for movie in movies:

    title = movie["title"]
    year = movie.get("year")

    safe_title = safe_filename(title)
    filename = f"{POSTER_DIR}/{safe_title}.webp"

    # Skip if poster already exists
    if os.path.exists(filename):
        movie["poster"] = filename
        print("Skipping (exists):", title)
        continue

    result = find_movie(title, year)

    if not result:
        print("No match:", title)
        continue

    poster_path = result.get("poster_path")

    if not poster_path:
        print("No poster:", title)
        continue

    poster_url = POSTER_BASE + poster_path

    download_webp(poster_url, filename)

    movie["poster"] = filename

    print("Saved:", title)


# overwrite the original JSON file
with open(JSON_FILE, "w") as f:
    json.dump(movies, f, indent=2)
