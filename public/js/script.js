let questionCount = 1;

document.getElementById('add-question-btn').addEventListener('click', function() {
    questionCount++;

    const questionContainer = document.createElement('div');
    questionContainer.classList.add('question-group');
    questionContainer.innerHTML = `
        <h4 class="text-primary">Pregunta ${questionCount}</h4>
        <div class="form-group">
            <label for="pregunta_${questionCount}">Pregunta</label>
            <textarea name="preguntas[]" class="form-control autoexpand" required></textarea>
        </div>
        
        <!-- Contenedor de los incisos (A, B, C, D) -->
        <div class="incisos-container">
            <div class="form-group">
                <label for="inciso_${questionCount}_a">Inciso A</label>
                <input type="text" name="incisos[][a]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="inciso_${questionCount}_b">Inciso B</label>
                <input type="text" name="incisos[][b]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="inciso_${questionCount}_c">Inciso C</label>
                <input type="text" name="incisos[][c]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="inciso_${questionCount}_d">Inciso D</label>
                <input type="text" name="incisos[][d]" class="form-control" required>
            </div>
        </div>
    `;
    document.getElementById('questions-container').appendChild(questionContainer);

    // Reaplicar el script de autoexpansión para los nuevos textarea
    document.querySelectorAll('textarea.autoexpand').forEach((textarea) => {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';  // Restablece la altura para ajustarla
            this.style.height = (this.scrollHeight) + 'px'; // Ajusta la altura al contenido
        });
    });
});

// Inicializar el comportamiento de autoexpansión para los textarea existentes
document.querySelectorAll('textarea.autoexpand').forEach((textarea) => {
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';  // Restablece la altura para ajustarla
        this.style.height = (this.scrollHeight) + 'px'; // Ajusta la altura al contenido
    });
});
