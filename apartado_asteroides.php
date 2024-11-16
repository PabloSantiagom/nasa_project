<div id="asteroides">
    <h2>ASTEROIDES</h2>
    <div  id="hero">
        <!-- Ejemplo de 4 apartados -->
        <div class="apartado">
            <h3>Título 1</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 2</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 3</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 4</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
    </div>
</div>

<div class="explora-mas">
    <h2>Explora Más</h2>
    <div class="cuadricula">
        <!-- Ejemplo de 4 apartados -->
        <div class="apartado">
            <h3>Título 1</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 2</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 3</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
        <div class="apartado">
            <h3>Título 4</h3>
            <p>Descripción breve o contenido relacionado.</p>
            <a href="#">Ver más</a>
        </div>
    </div>
</div>


------------------- css ----------------------- 
.asteroides {
    padding: 20px;
    background-color: #f4f4f4;
    text-align: center;
}

.asteroides h2 {
    margin-bottom: 15px;
    font-size: 24px;
}


.cuadricula {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
}

.apartado {
    background: #ffffff;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.apartado h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.apartado p {
    font-size: 14px;
    margin-bottom: 10px;
}

.apartado a {
    color: #007bff;
    text-decoration: none;
}

.apartado a:hover {
    text-decoration: underline;
}