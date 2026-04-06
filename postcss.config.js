import purgecss from '@fullhuman/postcss-purgecss';

export default {
    plugins: [
        purgecss({
            // Scanne tous les fichiers qui peuvent référencer des classes CSS
            content: [
                './resources/views/**/*.blade.php',
                './resources/js/**/*.js',
            ],

            // Conserve les classes ajoutées dynamiquement par Bootstrap JS
            // (collapse, modal, dropdown, etc.) et celles ajoutées par PHP/JS
            safelist: {
                // Classes Bootstrap activées dynamiquement
                standard: [
                    'show', 'fade', 'collapsing', 'collapsed',
                    'active', 'disabled', 'open',
                    'in', 'out',
                    'modal-open', 'modal-backdrop',
                    'navbar-toggler',
                ],
                // Patterns des classes Bootstrap responsive/état
                deep: [
                    /^modal/,
                    /^offcanvas/,
                    /^tooltip/,
                    /^popover/,
                    /^dropdown/,
                    /^collapse/,
                    /^carousel/,
                    /^alert/,
                    /^was-validated/,
                    /^is-invalid/,
                    /^is-valid/,
                ],
                // Classes avec préfixes responsive (col-lg-*, d-md-*, etc.)
                greedy: [
                    /^col-/,
                    /^row/,
                    /^d-/,
                    /^flex-/,
                    /^align-/,
                    /^justify-/,
                    /^gap-/,
                    /^g-/,
                    /^order-/,
                    /^offset-/,
                ],
            },

            // Traite les sélecteurs spéciaux CSS (attributs, pseudo-classes)
            defaultExtractor: (content) =>
                content.match(/[\w-/:]+(?<!:)/g) || [],
        }),
    ],
};
