document.addEventListener('alpine:init', () => {

    Alpine.bind('Tabs', () => ({
        'x-id' () {
            return ['tabs'];
        },
        ':id' () {
            return this.$id('tabs');
        },
    }));

    Alpine.bind('TabButton', (tab) => ({
        'role': 'tab',
        ':aria-controls' () {
            return this.$id('tabs', `panel-${tab}`);
        },
        ':aria-selected' () {
            return this.currentTab === tab;
        },
        ':class' () {
            return {
                'tab--active': this.currentTab === tab,
            };
        },
        ':id' () {
            return this.$id('tabs', `button-${tab}`);
        },
        ':tabindex' () {
            return this.currentTab === tab ? 0 : -1;
        },
        '@click' () {
            this.currentTab = tab;
        },
    }));

    Alpine.bind('TabPanel', (tab) => ({
        'role': 'tabpanel',
        'tabindex': 0,
        ':aria-labeledby' () {
            return this.$id('tabs', `button-${tab}`);
        },
        ':hidden' () {
            return this.currentTab !== tab;
        },
        ':id' () {
            return this.$id('tabs', `panel-${tab}`);
        },
    }));
});
