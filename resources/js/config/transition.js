"use strict";

/**
 * Sistema global de transiciones para modales
 * Utiliza View Transition API para crear efectos fluidos de apertura y cierre
 */

class ModalTransitions {
    constructor() {
        this.currentOriginElement = null;
        this.currentModal = null;
        this.currentModalInstance = null;
    }

    /**
     * Abre un modal con transición animada desde el elemento origen
     * @param {HTMLElement|KTModal} modalInstance - Instancia del modal de Metronic o elemento modal
     * @param {HTMLElement} originElement - Elemento desde el cual se origina la transición
     * @param {Object} options - Opciones adicionales para la transición
     */
    async openModalWithTransition(modalInstance, originElement, options = {}) {
        try {
            // Determinar si es una instancia de KTModal o elemento HTML
            let modalElement = null;
            this.currentModalInstance = null;

            // Si nos pasan una instancia con métodos show/hide, intentar extraer su elemento
            if (modalInstance && typeof modalInstance === 'object') {
                if (typeof modalInstance.show === 'function' || typeof modalInstance.hide === 'function') {
                    this.currentModalInstance = modalInstance;
                }

                // Intentar varias propiedades comunes que contienen el elemento
                modalElement = modalInstance.element || modalInstance._element || modalInstance._target || modalInstance.target || modalInstance.el || modalInstance.getElement && modalInstance.getElement() || modalInstance.modalElement || null;
            }

            // Si aún no tenemos un elemento, puede que nos hayan pasado directamente el elemento DOM
            if (!modalElement && modalInstance instanceof HTMLElement) {
                modalElement = modalInstance;
                this.currentModalInstance = null;
            }

            // Si origin viene como jQuery, obtener el elemento DOM
            if (originElement && originElement.jquery) {
                originElement = originElement[0];
            }

            if (!modalElement || !originElement) {
                console.warn('Modal element or origin element not found', { modalInstance, modalElement, originElement });
                this._showModalFallback(modalInstance);
                return;
            }

            // Si la instancia KTModal fue pasada por opciones, usarla
            if (options && options.ktInstance) {
                this.currentModalInstance = options.ktInstance;
            }

            // Guardar referencias
            this.currentModal = modalElement;
            this.currentOriginElement = originElement;

            // Buscar el contenedor principal del modal (puede variar según la estructura)
            const modalContainer = modalElement.querySelector('.modal-dialog') || 
                                 modalElement.querySelector('.modal-content') ||
                                 modalElement.querySelector('[class*="modal"]') ||
                                 modalElement;

            // Aplicar las clases y nombres de transición
            const viewTransitionClass = options.transitionClass || "vt-element-animation";
            
            modalContainer.style.viewTransitionClass = viewTransitionClass;
            modalContainer.style.viewTransitionName = "vt-shared";

            originElement.style.viewTransitionClass = viewTransitionClass;
            originElement.style.viewTransitionName = "vt-shared";
            originElement.setAttribute("origin-element", "");

            // Verificar soporte para View Transition API
            if (!document.startViewTransition) {
                this._showModalFallback(modalInstance);
                return;
            }

            // Ejecutar la transición
            const viewTransition = document.startViewTransition(() => {
                // Mostrar el modal
                if (this.currentModalInstance && typeof this.currentModalInstance.show === 'function') {
                    this.currentModalInstance.show();
                } else {
                    modalElement.classList.add('show');
                    modalElement.style.display = 'block';
                }

                // Limpiar el elemento origen
                originElement.style.viewTransitionClass = "";
                originElement.style.viewTransitionName = "";
            });

            await viewTransition.finished;

            // Limpiar estilos del contenedor modal
            modalContainer.style.viewTransitionClass = "";
            modalContainer.style.viewTransitionName = "";

            // Configurar eventos de cierre si no están configurados
            this._setupCloseEvents(modalElement);

        } catch (error) {
            console.error('Error en transición de apertura:', error);
            this._showModalFallback(modalInstance);
        }
    }

    /**
     * Cierra el modal con transición animada hacia el elemento origen
     * @param {Object} options - Opciones adicionales para la transición
     */
    async closeModalWithTransition(options = {}) {
        try {
            if (!this.currentModal) {
                console.warn('No hay modal activo para cerrar');
                return;
            }

            const modalElement = this.currentModal;
            const modalContainer = modalElement.querySelector('.modal-dialog') || 
                                 modalElement.querySelector('.modal-content') ||
                                 modalElement.querySelector('[class*="modal"]') ||
                                 modalElement;

            const viewTransitionClass = options.transitionClass || "vt-element-animation-closing";

            // Verificar si el elemento origen sigue siendo válido
            let originElement = this.currentOriginElement;
            if (!originElement || !this._isElementVisible(originElement)) {
                this._hideModalFallback();
                return;
            }

            // Verificar soporte para View Transition API
            if (!document.startViewTransition) {
                this._hideModalFallback();
                return;
            }

            // Estado inicial: el modal tiene el nombre compartido
            modalContainer.style.viewTransitionClass = viewTransitionClass;
            modalContainer.style.viewTransitionName = "vt-shared";

            // Ejecutar la transición
            const viewTransition = document.startViewTransition(() => {
                // En el nuevo estado: asignar nombre al origen y ocultar modal
                originElement.style.viewTransitionClass = viewTransitionClass;
                originElement.style.viewTransitionName = "vt-shared";

                // Ocultar el modal
                if (this.currentModalInstance && typeof this.currentModalInstance.hide === 'function') {
                    this.currentModalInstance.hide();
                } else {
                    modalElement.classList.remove('show');
                    modalElement.style.display = 'none';
                }
            });

            await viewTransition.finished;

            // Limpiar todos los estilos
            this._cleanup();

        } catch (error) {
            console.error('Error en transición de cierre:', error);
            this._hideModalFallback();
        }
    }

    /**
     * Verifica si un elemento es visible
     * @param {HTMLElement} element 
     * @returns {boolean}npm insta ll
     */
    _isElementVisible(element) {
        try {
            const style = window.getComputedStyle(element);
            return style.display !== 'none' && 
                   style.visibility !== 'hidden' && 
                   !element.classList.contains('hide') &&
                   element.offsetParent !== null;
        } catch {
            return false;
        }
    }

    /**
     * Muestra el modal sin transición (fallback)
     * @param {HTMLElement|KTModal} modalInstance 
     */
    _showModalFallback(modalInstance) {
        if (modalInstance && typeof modalInstance.show === 'function') {
            modalInstance.show();
        } else if (modalInstance) {
            modalInstance.classList.add('show');
            modalInstance.style.display = 'block';
        }
    }

    /**
     * Oculta el modal sin transición (fallback)
     */
    _hideModalFallback() {
        if (this.currentModalInstance && typeof this.currentModalInstance.hide === 'function') {
            this.currentModalInstance.hide();
        } else if (this.currentModal) {
            this.currentModal.classList.remove('show');
            this.currentModal.style.display = 'none';
        }
        this._cleanup();
    }

    /**
     * Configura los eventos de cierre del modal
     * @param {HTMLElement} modalElement 
     */
    _setupCloseEvents(modalElement) {
        // Buscar botón de cierre
        const closeBtn = modalElement.querySelector('[data-bs-dismiss="modal"], .btn-close, [class*="close"]');
        if (closeBtn && !closeBtn.hasAttribute('data-transition-close-setup')) {
            closeBtn.setAttribute('data-transition-close-setup', 'true');
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.closeModalWithTransition();
            });
        }

        // Evento de clic en el fondo del modal
        if (!modalElement.hasAttribute('data-transition-backdrop-setup')) {
            modalElement.setAttribute('data-transition-backdrop-setup', 'true');
            modalElement.addEventListener('click', (e) => {
                if (e.target === modalElement) {
                    this.closeModalWithTransition();
                }
            });
        }

        // Evento de tecla Escape
        if (!document.hasAttribute('data-transition-escape-setup')) {
            document.setAttribute('data-transition-escape-setup', 'true');
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.currentModal) {
                    this.closeModalWithTransition();
                }
            });
        }
    }

    /**
     * Limpia todas las referencias y estilos
     */
    _cleanup() {
        if (this.currentModal) {
            const modalContainer = this.currentModal.querySelector('.modal-dialog') || 
                                 this.currentModal.querySelector('.modal-content') ||
                                 this.currentModal.querySelector('[class*="modal"]') ||
                                 this.currentModal;
            
            modalContainer.style.viewTransitionClass = "";
            modalContainer.style.viewTransitionName = "";
        }

        if (this.currentOriginElement) {
            this.currentOriginElement.style.viewTransitionClass = "";
            this.currentOriginElement.style.viewTransitionName = "";
            this.currentOriginElement.removeAttribute("origin-element");
        }

        this.currentOriginElement = null;
        this.currentModal = null;
        this.currentModalInstance = null;
    }

    /**
     * Fuerza el cierre y limpieza de cualquier modal activo
     */
    forceClose() {
        this._hideModalFallback();
    }
}

// Crear instancia global
const modalTransitions = new ModalTransitions();

// Exportar funciones globales para facilitar el uso
window.openModalWithTransition = (modalInstance, originElement, options) => {
    return modalTransitions.openModalWithTransition(modalInstance, originElement, options);
};

window.closeModalWithTransition = (options) => {
    return modalTransitions.closeModalWithTransition(options);
};

window.forceCloseModalTransition = () => {
    return modalTransitions.forceClose();
};

// Exportar para módulos ES6
export { modalTransitions, ModalTransitions };

// Exportar por defecto
export default modalTransitions;
