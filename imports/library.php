<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Library</title>

<style>

.library-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: stretch; /* was center */
    padding: 20px;
}

h1 {
    font-size: 42px;
    letter-spacing: 4px;
    margin-bottom: 60px;
}

.library-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 30px;
    width: 100%;
    max-width: 1000px; /* adjust if you want wider */
}

.library-item {
    padding: 60px 30px;
    text-align: center;
    border-radius: 12px;

    /* Strong base shadow */
    box-shadow: 
        0 12px 30px rgba(0,0,0,0.35),
        0 4px 10px rgba(0,0,0,0.25);

    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.library-item:hover {
    transform: translateY(-10px) scale(1.04);

    /* More intense, deeper shadow */
    box-shadow:
        0 30px 70px rgba(0,0,0,0.55),
        0 10px 20px rgba(0,0,0,0.4);
}

.library-item h2 {
    font-size: 24px;
    margin-bottom: 14px;
    letter-spacing: 1px;
}

.library-item p {
    font-size: 14px;
    color: #666;
    margin: 0;
}

</style>
</head>
<body>

<div class="library-wrapper">
    <p>My library is a place for me to catalog and share some of my media and interests.</p>
    <p>While the library isn't a place to access the media itself, I think it can give a look into what I'm interested in or have seen, potentially influencing me as a person.
        I also have plans to potentially add some features like my thoughts on a given piece of media, or give anyone who wants to comment a place to do that.</p>
        <p>Going back to how the library doesn't give you access to my actual media, if you're interested in any of it, just reach out to me and I can probably give you or let you borrow anything you see on the library. Think of it like how actaul librarys have an online catalog of items you can order in to the physical library.</p>
    </p>
    <div class="library-grid">

        <a href="/music" class = "library-item">
                <h2>Music</h2>
                <p>Albums & Archive</p>
        </a>

        <a href="/books" class = "library-item">
                <h2>Books</h2>
                <p>Reading & Reviews</p>  
        </a>

        <a href="/movies" class = "library-item">
                <h2>Movies</h2>
                <p>Film Collection</p>
        </a>

        <a href="/clothes" class = "library-item">
                <h2>Clothing</h2>
                <p>Wardrobe & Outfit Generator</p>
        </a>

    </div>

</div>

</body>
</html>