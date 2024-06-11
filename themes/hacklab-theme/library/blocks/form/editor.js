import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, Placeholder, SelectControl, SVG } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from '../shared/hooks';
import { EMPTY_ARR, sortByString } from '../shared/utils';

import metadata from './block.json';

function getOptions (forms) {
    if (!forms) {
        return EMPTY_ARR;
    }

    return Object.values(forms)
        .map((form) => ({
            label: form.label,
            value: form.slug,
        }))
        .sort(sortByString('label'));
}

function Icon ({ size }) {
    // https://icon-sets.iconify.design/fluent/form-48-filled/
    return (
        <SVG height={size} width={size} viewBox="0 0 48 48">
            <Path fill="currentColor" d="M18.5 21.5a2 2 0 1 1-4 0a2 2 0 0 1 4 0m-2 13a2 2 0 1 0 0-4a2 2 0 0 0 0 4M6 12.25A6.25 6.25 0 0 1 12.25 6h23.5A6.25 6.25 0 0 1 42 12.25v23.5A6.25 6.25 0 0 1 35.75 42h-23.5A6.25 6.25 0 0 1 6 35.75zm15 9.25a4.5 4.5 0 1 0-9 0a4.5 4.5 0 0 0 9 0M16.5 37a4.5 4.5 0 1 0 0-9a4.5 4.5 0 0 0 0 9m-3.25-26a1.25 1.25 0 1 0 0 2.5h21.5a1.25 1.25 0 1 0 0-2.5zM23 21.75c0 .69.56 1.25 1.25 1.25h10.5a1.25 1.25 0 1 0 0-2.5h-10.5c-.69 0-1.25.56-1.25 1.25M24.25 31a1.25 1.25 0 1 0 0 2.5h10.5a1.25 1.25 0 1 0 0-2.5z"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const { formId } = attributes;

    const { data: forms } = useRestApi('hacklabr/v2/forms');

    const blockProps = useBlockProps();

    const options = useMemo(() => {
        const baseOptions = getOptions(forms);
        return [{ label: __('Select option', 'hacklabr'), value: '' }, ...baseOptions];
    }, [forms]);

    return (
        <div {...blockProps}>
            <Placeholder label={__('Form', 'hacklabr')} icon={Icon} isColumnLayout={true}>
                <SelectControl
                    label={__('Form', 'hacklabr')}
                    options={options}
                    value={formId}
                    onChange={(formId) => setAttributes({ formId })}
                />
            </Placeholder>
        </div>
    )
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
});
