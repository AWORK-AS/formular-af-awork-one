import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';
import '../styles/block.scss';

const translations = window.cfaBlockTranslations || {};

registerBlockType('contact-form-app/contact-form', {
    apiVersion: 2,
    title: translations.contactForm || 'Contact Form',
    icon: 'email-alt',
    category: 'widgets',
    attributes: {
        headline: {
            type: 'string',
            default: translations.headline || 'Get in Touch With Us',
        },
        color: {
            type: 'string',
            default: '#205E77',
        },
    },
    edit: Edit,
    save,
});