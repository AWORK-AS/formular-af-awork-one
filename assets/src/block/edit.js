import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, TextControl } from '@wordpress/components';
import { blockIcon, blockStyle } from './utils';

/**
 * @typedef {import('@wordpress/blocks').BlockEditProps<Props>} BlockEditProps
 */

/**
 * @typedef {Object} Props The custom block props.
 * @property {string} href The block url link attribute.
 * @property {Record<string, any>} style The block custom style attribute.
 * @property {boolean} isPreview Attribute para malaman kung nasa preview mode.
 */

/**
 * The edit function describes the structure of your block in the context of the editor.
 *
 * @see https://wordpress.org/gutenberg/handbook/block-api/block-edit-save
 * @param {BlockEditProps} props - The block attributes
 * @return {JSX.Element} Element to render.
 */
export const Edit = ( { isSelected, attributes, setAttributes } ) => {
	const blockProps = useBlockProps( {
		style: {
			...attributes.style,
			...blockStyle,
		},
	} );

	
	if ( attributes.isPreview ) {
		const previewImageUrl = window.cfaBlockData.previewImage;
		return (
			<div { ...blockProps }>
				<img
					src={ previewImageUrl }
					alt="Block Preview"
					style={ { width: '100%', height: 'auto' } }
				/>
			</div>
		);
	}

	
	return (
		<div { ...blockProps }>
			<InspectorControls key="setting">
				<Panel header="Settings">
					<PanelBody
						title="Block Settings"
						icon={ 'admin-settings' }
						initialOpen={ true }
					>
						<PanelRow>
							<TextControl
								label="Link Href"
								type={ 'url' }
								value={ attributes.href }
								onChange={ ( target ) =>
									setAttributes( { href: target } )
								}
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
			{ blockIcon }
			<h4
				style={
					isSelected
						? { border: '2px solid red' }
						: { border: 'none' }
				}
			>
				<a
					href={ attributes.href ?? '' }
					className={ 'has-link-color' }
				>
					Hello World, WordPress Plugin Boilerplate Powered here!
				</a>
			</h4>
		</div>
	);
};
