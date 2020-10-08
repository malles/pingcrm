module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/recommended',
    ],
    parserOptions: {
        'parser': 'babel-eslint',
    },
    rules: {
        'semi': [
            2,
            'always',
        ],
        'comma-dangle': [
            2,
            'always',
        ],
        'no-cond-assign': [
            2,
            'always',
        ],
        'no-console': 1,
        'no-constant-condition': 2,
        'no-control-regex': 2,
        'no-debugger': 2,
        'no-dupe-args': 2,
        'no-dupe-keys': 2,
        'no-duplicate-case': 2,
        'no-empty-character-class': 2,
        'no-empty': 2,
        'no-ex-assign': 2,
        'no-extra-boolean-cast': 2,
        'no-extra-parens': [
            2,
            'functions',
        ],
        'no-extra-semi': 2,
        'no-func-assign': 2,
        'no-inner-declarations': [
            2,
            'both',
        ],
        'no-invalid-regexp': 2,
        'no-irregular-whitespace': 2,
        'no-negated-in-lhs': 2,
        'no-obj-calls': 2,
        'no-regex-spaces': 2,
        'no-sparse-arrays': 2,
        'no-unreachable': 1,
        'use-isnan': 2,
        'valid-typeof': 2,
        'no-unexpected-multiline': 1,
        'accessor-pairs': [
            1,
            {
                'getWithoutSet': true,
                'setWithoutGet': true,
            },
        ],
        'curly': [
            2,
            'all',
        ],
        'default-case': 1,
        'dot-notation': [
            1,
            {
                'allowKeywords': true,
            },
        ],
        'dot-location': [
            1,
            'property',
        ],
        'eqeqeq': [
            2,
            'smart',
        ],
        'guard-for-in': 2,
        'no-alert': 0,
        'no-caller': 2,
        'no-else-return': 1,
        'no-eval': 2,
        'no-fallthrough': 1,
        'no-implied-eval': 2,
        'no-lone-blocks': 1,
        'no-loop-func': 1,
        'no-octal': 1,
        'no-proto': 1,
        'no-redeclare': [
            2,
            {
                'builtinGlobals': false,
            },
        ],
        'no-useless-call': 1,
        'strict': [
            2,
            'global',
        ],
        'no-delete-var': 2,
        'no-undef': 1,
        'no-unused-vars': 1,
        'no-use-before-define': [
            1,
            'nofunc',
        ],
        'brace-style': [
            1,
            '1tbs',
            {
                'allowSingleLine': true,
            },
        ],
        'indent': [
            1,
            4,
            {
                'SwitchCase': 1,
            },
        ],
        'key-spacing': [
            1,
            {
                'beforeColon': false,
            },
        ],
        'new-parens': 1,
        'no-array-constructor': 2,
        'no-mixed-spaces-and-tabs': 1,
        'no-trailing-spaces': [
            1,
            {
                'skipBlankLines': false,
            },
        ],
        'no-unneeded-ternary': 1,
        'quotes': [
            1,
            'single',
            'avoid-escape',
        ],
        'constructor-super': 1,
        'no-var': 2,
        'vue/max-attributes-per-line': [
            2,
            {
                'singleline': 5,
                'multiline': {
                    'max': 3,
                    'allowFirstLine': true,
                },
            },
        ],
        'vue/require-default-prop': 0,
        'vue/valid-v-for': 1,
        'vue/require-v-for-key': 1,
        'vue/no-parsing-error': 1,
        'vue/html-closing-bracket-newline': 0,
        'vue/singleline-html-element-content-newline': ['warning', {
            'ignores': ['pre', 'textarea', 'option'],
        }],
        'vue/no-v-html': 0,
        'vue/require-component-is': 0,
        'vue/prop-name-casing': 1,
        'vue/html-self-closing': 0,
        'vue/html-indent': ['warning', 4, {
            'attribute': 1,
            'closeBracket': 0,
            'alignAttributesVertically': true,
            'ignores': [],
        }],
    },
}
