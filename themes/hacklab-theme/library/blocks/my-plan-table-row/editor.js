import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, Placeholder, RadioControl, SVG, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const DISPLAY_OPTIONS = [
    { label: __('No'), value: 'no' },
    { label: __('Yes'), value: 'yes' },
    { label: __('Custom text', 'hacklabr'), value: 'custom' },
];

const PLANS = ['conexao', 'essencial', 'vivencia', 'institucional'];

const PLANS_LABELS = {
    'conexao': 'Conexão',
    'essencial': 'Essencial',
    'vivencia': 'Vivência',
    'institucional': 'Institucional',
};

function Icon ({ size }) {
    // https://icon-sets.iconify.design/grommet-icons/plan/
    return (
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="none" stroke="currentColor" stroke-width="2" d="M18 4V0zM7 18H5zm12 0H9zM7 14H5zm12 0H9zM6 4V0zM1 9h22zm0 14h22V4H1z"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const { plans, text } = attributes;

    const blockProps = useBlockProps({ className: 'my-plan-table-row__editor-grid' });

    function changePlan (plan, property, value) {
        setAttributes({
            plans: { ...plans, [plan]: { ...plans[plan], [property]: value } },
        });
    }

    return (
        <div {...blockProps}>
            <div className="my-plan-table-row__editor-text">
                <TextControl
                    label={__('Benefits', 'hacklabr')}
                    value={text}
                    onChange={(text) => setAttributes({ text })}
                />
            </div>
            {PLANS.map((slug) => (
                <div className="my-plan-table-row__editor-plan" key={slug}>
                    <RadioControl
                        label={PLANS_LABELS[slug]}
                        selected={plans[slug].type}
                        options={DISPLAY_OPTIONS}
                        onChange={(type) => changePlan(slug, 'type', type)}
                    />
                    {(plans[slug].type === 'custom') ? (
                        <TextControl
                            label={__('Custom text', 'hacklabr')}
                            value={plans[slug].text}
                            onChange={(text) => changePlan(slug, 'text', text)}
                        />
                    ) : null}
                </div>
            ))}
        </div>
    );
}

function saveCell({ text, type }) {
    if (type === 'no') {
        return <iconify-icon icon="fa-solid:times"></iconify-icon>;
    } else if (type === 'yes') {
        return <iconify-icon icon="fa-solid:check"></iconify-icon>;
    } else {
        return <span>{text}</span>;
    }
}

function Save ({ attributes }) {
    const { plans, text } = attributes;

    return (
        <tr className="my-plan-table-row">
            <td className="my-plan-table-row__benefits">{text}</td>
            {PLANS.map((slug) => (
                <td className={`my-plan-table__${slug}`}>{saveCell(plans[slug])}</td>
            ))}
        </tr>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
