document.addEventListener('alpine:init', () => {

    Alpine.bind('TabButton', ($id, currentTab, tab) => {
        const isCurrent = currentTab === tab;

        return {
            'aria-controls': $id('tabs', `panel-${tab}`),
            'aria-selected': isCurrent,
            id: $id('tabs', `button-${tab}`),
            role: 'tab',
            tabindex: isCurrent ? 0 : -1,
            '@click' () {
                this.currentTab = tab;
            }
        };
    });

    Alpine.bind('TabPanel', ($id, currentTab, tab) => {
        const isCurrent = currentTab === tab;

        return {
            'aria-labeledby': $id('tabs', `button-${tab}`),
            // hidden: !isCurrent,
            id: $id('tabs', `panel-${tab}`),
            role: 'tabpanel',
            tabindex: 0,
        };
    });
});
