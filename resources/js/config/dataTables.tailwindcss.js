/**
 * DataTables Tailwind CSS integration
 * Adaptación para Vite + ES Modules
 */

import $ from 'jquery';
import DataTable from 'datatables.net-dt';

// Registrar DataTables en jQuery
DataTable.use($);

// Comprobar la integración
if (!$.fn.DataTable) {
    throw new Error(
        'DataTables no está registrado correctamente en jQuery'
    );
}

/**
 * Configuración general
 */
$.extend(true, DataTable.defaults, {
    renderer: 'tailwindcss',
    responsive: false,
    scrollX: true
});

/**
 * Clases Tailwind
 */
$.extend(true, DataTable.ext.classes, {
    container: 'dt-container dt-tailwindcss',

    search: {
        input: 'input input-sm'
    },

    length: {
        select: 'select select-sm'
    },

    processing: {
        container: 'dt-processing'
    },

    paging: {
        active: 'btn disabled bg-gray-200',
        notActive: 'bg-transparent',
        button: 'btn',
        enabled: 'btn',
        notEnabled: 'text-gray-300 dark:text-gray-600'
    },

    table: 'dataTable min-w-full text-sm align-middle whitespace-nowrap',

    thead: {
        row: 'border-b border-gray-100 dark:border-gray-700/50',
        cell: 'px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-left dark:text-gray-50 dark:bg-gray-700/25'
    },

    tbody: {
        row: '',
        cell: 'p-3'
    },

    tfoot: {
        row: 'even:bg-gray-50 dark:even:bg-gray-900/50',
        cell: 'p-3 text-left'
    }
});

/**
 * Renderizador de botones de paginación
 */
DataTable.ext.renderer.pagingButton.tailwindcss = function (
    settings,
    buttonType,
    content,
    active,
    disabled
) {
    const classes = DataTable.ext.classes.paging;

    const btnClasses = [
        classes.button,
        active ? classes.active : classes.notActive,
        disabled ? classes.notEnabled : classes.enabled
    ];

    const button = $('<a>', {
        href: disabled ? null : '#',
        class: btnClasses.join(' ')
    }).html(content);

    return {
        display: button,
        clicker: button
    };
};

/**
 * Renderizador del contenedor de paginación
 */
DataTable.ext.renderer.pagingContainer.tailwindcss = function (
    settings,
    buttonEls
) {
    const classes = DataTable.ext.classes.paging;

    if (buttonEls.length > 0) {
        buttonEls[0].addClass(classes.first || '');
        buttonEls[buttonEls.length - 1].addClass(classes.last || '');
    }

    return $('<ul/>')
        .addClass('pagination')
        .append(buttonEls);
};

/**
 * Renderizador de distribución de elementos
 */
DataTable.ext.renderer.layout.tailwindcss = function (
    settings,
    container,
    items
) {
    const row = $('<div/>', {
        class: items.full
            ? 'grid grid-cols-1 gap-4 mb-4'
            : 'grid grid-cols-2 gap-4 mb-4'
    }).appendTo(container);

    $.each(items, function (key, val) {
        let klass;

        if (val.table) {
            klass = 'col-span-2';
        } else if (key === 'start') {
            klass = 'justify-self-start';
        } else if (key === 'end') {
            klass = 'col-start-2 justify-self-end';
        } else {
            klass = 'col-span-2 justify-self-center';
        }

        $('<div/>', {
            id: val.id || null,
            class: klass + ' ' + (val.className || '')
        })
            .append(val.contents)
            .appendTo(row);
    });
};

// Exportaciones
export { $, DataTable };
export default DataTable;