import apiFetch from '@wordpress/api-fetch';
import { Button, PanelRow } from '@wordpress/components';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useState } from '@wordpress/element';
import { rotateRight } from '@wordpress/icons';
import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';

registerPlugin('ethos-crm-sync', {
    icon: rotateRight,
    render () {
        const [loading, setLoading] = useState(false);

        const { entityId, entityName } = globalThis.hl_sync_crm_data;

        async function syncWithCrm () {
            try {
                setLoading(true);

                await apiFetch({
                    method: 'PUT',
                    path: 'hacklabr/v2/crm/entity',
                    body: JSON.stringify({ entityId, entityName }),
                });

                setLoading(false);
                window.location.reload();
            } catch (err) {
                console.error(err);
                setLoading(false);
            }
        }

        if (entityName && entityId) {
            return (
                <PluginDocumentSettingPanel title={__('Sync with CRM', 'hacklabr')}>
                    <PanelRow>
                        <Button icon={rotateRight} variant="primary" disabled={loading} onClick={syncWithCrm}>
                            {__('Sync with CRM', 'hacklabr')}
                        </Button>
                    </PanelRow>
                </PluginDocumentSettingPanel>
            );
        } else {
            return null;
        }
    }
});
