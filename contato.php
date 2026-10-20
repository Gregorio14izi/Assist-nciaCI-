<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/includes/header.php';
?>

<main class="container my-5">
    <section class="row g-4">
        <!-- Formulário de Contato -->
        <article class="col-lg-7">
            <div class="card shadow-sm p-4 border-0">
                <h1 class="h3 fw-bold mb-3">Fale Conosco</h1>
                <p class="text-muted mb-4">Preencha o formulário abaixo para tirar dúvidas, solicitar orçamentos ou acompanhar o estado do seu equipamento.</p>

                <form action="#" method="POST" onsubmit="alert('Mensagem enviada com sucesso! Entraremos em contacto brevemente.'); return false;">
                    <div class="mb-3">
                        <label for="nome_contato" class="form-label fw-bold">Nome Completo *</label>
                        <input type="text" id="nome_contato" name="nome" class="form-control" placeholder="Digite o seu nome completo" required>
                    </div>

                    <div class="mb-3">
                        <label for="email_contato" class="form-label fw-bold">E-mail *</label>
                        <input type="email" id="email_contato" name="email" class="form-control" placeholder="exemplo@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone_contato" class="form-label fw-bold">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone_contato" name="telefone" class="form-control" placeholder="(11) 99999-9999">
                    </div>

                    <div class="mb-3">
                        <label for="mensagem_contato" class="form-label fw-bold">Mensagem / Equipamento *</label>
                        <textarea id="mensagem_contato" name="mensagem" class="form-control" rows="4" placeholder="Descreva o modelo do seu equipamento e o problema apresentado..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold text-dark w-100">Enviar Mensagem</button>
                </form>
            </div>
        </article>

        <!-- Informações e Imagem Institucional -->
        <aside class="col-lg-5">
            <div class="card shadow-sm p-4 mb-4 bg-dark text-light border-0">
                <h2 class="h4 fw-bold text-warning mb-3">📍 AssistênciaCi</h2>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Endereço:</strong> Av. Principal das Tecnologias, 1000 - Centro</li>
                    <li class="mb-2"><strong>Atendimento:</strong> Segunda a Sexta, das 08h00 às 18h00</li>
                    <li class="mb-2"><strong>Sábados:</strong> das 08h00 às 12h00</li>
                    <li class="mb-2"><strong>E-mail:</strong> contato@assistenciaci.com.br</li>
                    <li><strong>Telefone/WhatsApp:</strong> (11) 99999-8888</li>
                </ul>
            </div>

            <div class="text-center">
                <img src="<?= $baseUrl; ?>assets/img/atendimento.svg" alt="Atendimento ao cliente e recepção da loja AssistênciaCi" class="img-fluid rounded shadow-sm w-100">
            </div>
        </aside>
    </section>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>