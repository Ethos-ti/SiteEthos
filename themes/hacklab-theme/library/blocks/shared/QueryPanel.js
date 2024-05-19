import { PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { SelectPostType } from './SelectPostType';
import { SelectTerms } from './SelectTerms';
import { SelectTaxonomy } from './SelectTaxonomy';

export function QueryPanel ({ attributes, setAttributes, title = __('Query', 'hacklabr') }) {
    const { compare, noCompare, noPostType, noQueryTerms, noTaxonomy, order, orderBy, postType, queryTerms, showChildren, taxonomy } = attributes;

    const onChangePostType = (postType) => setAttributes({ postType, taxonomy: '', queryTerms: [] });

    const onChangeQueryTerms = (queryTerms) => setAttributes({ queryTerms });

    const onChangeTaxonomy = (taxonomy) => setAttributes({ taxonomy, queryTerms: [] });

    return (
        <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={title}>
            <PanelRow>
                <SelectPostType value={postType} onChange={onChangePostType}/>
            </PanelRow>
            <PanelRow>
                <SelectTaxonomy postType={postType} value={taxonomy} onChange={onChangeTaxonomy}/>
            </PanelRow>
            {(taxonomy) ? (
                <PanelRow>
                    <SelectTerms taxonomy={taxonomy} value={queryTerms} onChange={onChangeQueryTerms}/>
                </PanelRow>
            ) : null}
        </PanelBody>
    );
}
