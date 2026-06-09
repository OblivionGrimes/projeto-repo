<div class="flex h-full items-center justify-center relative">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-primary mb-2">404</h1>
        <h2 class="text-xl font-medium text-foreground mb-4">Página não encontrada</h2>
        <p class="text-muted-foreground mb-6">
            O caminho <code class="bg-muted px-2 py-1 rounded">/<?= htmlspecialchars($_GET['url'] ?? '') ?></code> não existe.
        </p>
        <a 
            href="<?= BASE_URL ?>d/manage/frames/index" 
            class="inline-block bg-primary text-primary-foreground px-6 py-2 rounded-md font-medium hover:bg-primary/90 transition-colors"
        >
            Voltar ao Painel
        </a>
    </div>
</div>