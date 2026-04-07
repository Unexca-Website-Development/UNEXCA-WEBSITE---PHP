<main class="login-container">
    <section class="login-card">
        <h1>Panel Administrativo</h1>
        <p>Inicia sesión para continuar</p>

        <?php if (isset($error)): ?>
            <div class="alerta alerta--error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?pagina=login" method="POST" class="login-form">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn btn--primario">Entrar</button>
        </form>
    </section>
</main>

<style>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    padding: 2rem;
}
.login-card {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
}
.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.alerta--error {
    background: #fee2e2;
    color: #b91c1c;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}
</style>
