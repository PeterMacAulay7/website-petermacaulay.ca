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
    align-items: center;
    padding: 80px 20px;
}

h1 {
    font-size: 42px;
    letter-spacing: 4px;
    margin-bottom: 60px;
}

.library-grid {
    width: 100%;
    max-width: 1000px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 40px;
}

.library-item a {
    text-decoration: none;
    color: inherit;
}

.library-item {
    padding: 60px 30px;
    text-align: center;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,1);
    transition: 0.25s ease;
}

.library-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
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
    
    <div class="library-grid">

        <div class="library-item">
            <a href="/music">
                <h2>Music</h2>
                <p>Albums & Archive</p>
            </a>
        </div>

        <div class="library-item">
            <a href="/books">
                <h2>Books</h2>
                <p>Reading & Reviews</p>
            </a>
        </div>

        <div class="library-item">
            <a href="/movies">
                <h2>Movies</h2>
                <p>Film Collection</p>
            </a>
        </div>

        <div class="library-item">
            <a href="/clothes">
                <h2>Clothing</h2>
                <p>Wardrobe & Outfit Generator</p>
            </a>
        </div>

    </div>

</div>

</body>
</html>