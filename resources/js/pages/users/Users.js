"use strict";
import { addSpinner, cleanErrors, deleteSpinner, instanceModal, processErrorResponse } from "../../config/global.js";
import modalTransitions from "../../config/transition.js";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2'
import $ from "jquery";

const Users = function () {
    let Options = {}
    function initTable() {
        Options.table = $("#table").DataTable({
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: true,
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, 'Todas']
            ],
            language: {
                url: "./assets/lang/es/es_es.json"
            },
            ajax: {
                url: route('Users.listado'),
                type: 'GET',
                data: q => {
                    q.search['value'] = document.querySelector('[name="search"]').value;
                    q.search['regex'] = false;
                    return q;
                }
            },
            columns: [
                { data: "id", title: '#', width: "1%", sClass: 'text-left vertical-align-middle', searchable: false, responsivePriority: 1 },
                { data: "nombre", title: 'Nombre', sClass: 'text-left vertical-align-middle', searchable: true, responsivePriority: 1 },
                { data: "email", title: 'Email', sClass: 'text-left vertical-align-middle', searchable: true, responsivePriority: 1 },
                { data: "role", title: 'Rol', sClass: 'text-left vertical-align-middle', searchable: false },
                { data: "status", title: 'Estado', sClass: 'text-left vetical-align-middle', searchable: false },
                { data: "id", title: 'Acciones', width: "1%", sClass: 'text-right vertical-align-middle', searchable: false, responsivePriority: 1 },
            ],
            columnDefs: [
                {
                    targets: [0, 1],
                    orderable: true,
                    render: function (data, type, row) {
                        if (data === null) {
                            return `-`;
                        }
                        return data;
                    }
                },
                {
                    targets: -3,
                    orderable: true,
                    render: function (data, type, row, meta) {
                        if (data === 'Admin') {
                            `<span class="badge badge-outline badge-info">${data}</span>`;
                        }
                        return `<span class="badge badge-outline badge-primary">${data}</span>`;
                    }
                },
                {
                    targets: -2,
                    orderable: true,
                    render: function (data, type, row, meta) {
                        if (data === 1) {
                            return `<span class="bade badge-outline badge-success">Activo</span>`;
                        }
                        return `<span class="badge badge-outline badge-danger">Inactivo</span>`;
                    }
                },
                {
                    targets: -1,
                    orderable: false,
                    render: function (data, type, row) {
                        let buttons = `<div class="flex flex-row gap-1 justify-center align-middle">
                            <button class="btn btn-sm btn-icon btn-clear btn-info" data-edit="${data}" data-tooltip="#edit_tooltip">
                                <i class="ki-filled ki-pencil"></i>
                            </button>
                            <div class="hidden rounded-xl shadow-default p-3 bg-light border border-gray-200 text-gray-700 text-xs font-normal" id="edit_tooltip">
                                Editar
                            </div>`;
                        if (row.status === 1) {
                            buttons += `<button data-updateStatus="${data}" class="btn btn-sm btn-icon btn-clear btn-danger" data-tooltip="#desactive_tooltip">
                                <i class="ki-filled ki-cross-circle"></i>
                            </button>
                            <div class="hidden rounded-xl shadow-default p-3 bg-light border border-gray-200 text-gray-700 text-xs font-normal" id="desactive_tooltip">
                                Desactivar
                            </div>`;
                        } else {
                            buttons += `<button  data-updateStatus="${data}" class="btn btn-sm btn-icon btn-clear btn-success" data-tooltip="#active_tooltip">
                                <i class="ki-filled ki-check-circle"></i>
                            </button>
                            <div class="hidden rounded-xl shadow-default p-3 bg-light border border-gray-200 text-gray-700 text-xs font-normal" id="active_tooltip">
                                Activar
                            </div>`;
                        }
                        buttons += `</div>`;
                        return buttons;
                    }
                }
            ],
            order: [
                [0, "desc"]
            ],
            scrollX: true,
            drawCallback: function (settings) {
                $('.dt-container').addClass('text-gray-800');
            },
            dom: "<'w-full'tr>" + "<'flex justify-between items-center px-4 py-2'<' flex flex-col justify-center align-middle items-center text-left text-[12px]'l><'w-1/2 text-[12px] flex flex-col md:flex-row justify-end align-middle items-center text-right'i p>>"
        });
        Options.table.on('draw', function () {
            KTComponents.init();
            let updateStatusButtons = document.querySelectorAll('[data-updateStatus]');
            updateStatusButtons.forEach('click', function () {
                buttons.addEventListener('click', function () {
                    updateStatus(button.getAttrubute())
                })
            })
        })
    }

    function init() {
        initTable();
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    Users.init();
})