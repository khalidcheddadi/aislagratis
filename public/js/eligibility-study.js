(function () {
    const form = document.getElementById('eligibilityForm');
    const page = document.querySelector('.eligibility-page');
    if (!form || !page) return;

    const steps = [...form.querySelectorAll('.elig-step')];
    const groups = [...form.querySelectorAll('.elig-opt-group')];
    const progress = [...page.querySelectorAll('[data-progress-step]')];
    const progressBar = page.querySelector('.eligibility-page-progress');
    const stepNumber = page.querySelector('#eligibilityCurrentStep');
    const stepDescription = page.querySelector('#eligibilityStepDescription');
    const propertyType = form.querySelector('#eligibilityPropertyType');
    const propertyTypeOther = form.querySelector('#eligibilityOtherType');
    const propertyTypeOtherSelect = page.querySelector('#eligibilityPropertyTypeOther');
    const accessType = form.querySelector('#eligibilityAccessType');
    const stepDescriptions = [
        'Primero, cuéntanos sobre la vivienda y la actuación.',
        'Déjanos tus datos para poder contactar contigo.',
        'Indícanos la ubicación y confirma la política de privacidad.',
    ];
    let activeStep = 0;

    const propertyTypeMap = {
        unifamiliar: 'casa_unifamiliar',
        piso: 'piso',
        edificio: 'edificio',
    };
    const propertyKindByType = {
        casa_unifamiliar: 'unifamiliar',
        piso: 'piso',
        edificio: 'edificio',
    };

    function selectOption(group, option) {
        group.querySelectorAll('.elig-opt').forEach(button => {
            const isSelected = button === option;
            button.classList.toggle('active', isSelected);
            button.setAttribute('aria-pressed', String(isSelected));
        });
        const hidden = group.querySelector('input[type="hidden"]');
        if (hidden) hidden.value = option.dataset.value || '';
        group.classList.remove('is-error');
    }

    function updatePropertyType(value) {
        if (!propertyType) return;
        if (value === 'otro') {
            if (propertyTypeOther) propertyTypeOther.hidden = false;
            if (propertyTypeOtherSelect) propertyTypeOtherSelect.required = true;
            propertyType.value = propertyTypeOtherSelect?.value || '';
            return;
        }

        if (propertyTypeOther) propertyTypeOther.hidden = true;
        if (propertyTypeOtherSelect) {
            propertyTypeOtherSelect.required = false;
            propertyTypeOtherSelect.value = '';
        }
        propertyType.value = propertyTypeMap[value] || '';
    }

    groups.forEach(group => {
        group.querySelectorAll('.elig-opt').forEach(option => {
            option.setAttribute('aria-pressed', 'false');
            option.addEventListener('click', () => {
                selectOption(group, option);
                if (group.dataset.name === 'tipoInmueble') updatePropertyType(option.dataset.value);
                if (group.dataset.name === 'acceso' && accessType) {
                    accessType.value = option.dataset.accessType || '';
                }
            });
        });
    });

    propertyTypeOtherSelect?.addEventListener('change', () => {
        if (propertyType) propertyType.value = propertyTypeOtherSelect.value;
        propertyTypeOtherSelect.classList.remove('is-error');
    });

    function setStep(index, focus = false) {
        activeStep = index;
        steps.forEach((step, stepIndex) => step.classList.toggle('active', stepIndex === index));
        progress.forEach((item, stepIndex) => {
            item.classList.toggle('is-active', stepIndex === index);
            item.classList.toggle('is-complete', stepIndex < index);
        });
        if (progressBar) {
            progressBar.setAttribute('aria-valuenow', String(index + 1));
            progressBar.setAttribute('aria-valuetext', `Paso ${index + 1} de ${steps.length}`);
        }
        if (stepNumber) stepNumber.textContent = String(index + 1).padStart(2, '0');
        if (stepDescription) stepDescription.textContent = stepDescriptions[index];

        if (focus) {
            const firstControl = steps[index].querySelector('input:not([type="hidden"]), select, textarea, .elig-opt');
            firstControl?.focus({ preventScroll: true });
        }
        page.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function validateStep(index) {
        let valid = true;
        const step = steps[index];
        if (!step) return true;

        step.querySelectorAll('.elig-opt-group[data-required="true"]').forEach(group => {
            const selected = group.querySelector('input[type="hidden"]')?.value;
            if (!selected) {
                group.classList.add('is-error');
                valid = false;
            }
        });

        step.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
            if (input.type === 'hidden') {
                if (!input.value) valid = false;
                return;
            }

            const inputIsValid = input.type === 'checkbox'
                ? input.checked
                : Boolean(String(input.value).trim()) && input.checkValidity();

            input.classList.toggle('is-error', !inputIsValid);
            if (!inputIsValid) valid = false;
        });

        return valid;
    }

    form.querySelectorAll('[data-elig-next]').forEach(button => {
        button.addEventListener('click', () => {
            if (!validateStep(activeStep)) return;
            if (activeStep < steps.length - 1) setStep(activeStep + 1, true);
        });
    });

    form.querySelectorAll('[data-elig-prev]').forEach(button => {
        button.addEventListener('click', () => {
            if (activeStep > 0) setStep(activeStep - 1, true);
        });
    });

    form.addEventListener('submit', event => {
        for (let index = 0; index < steps.length; index += 1) {
            if (!validateStep(index)) {
                event.preventDefault();
                setStep(index, true);
                return;
            }
        }

        if (!propertyType?.value) {
            event.preventDefault();
            setStep(0, true);
            propertyTypeOtherSelect?.classList.add('is-error');
            return;
        }

    });

    form.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(input => {
        input.addEventListener('input', () => input.classList.remove('is-error'));
        input.addEventListener('change', () => input.classList.remove('is-error'));
    });

    form.querySelectorAll('.elig-opt-group input[type="hidden"]').forEach(hidden => {
        if (!hidden.value) return;
        const group = hidden.closest('.elig-opt-group');
        const option = [...group.querySelectorAll('.elig-opt')].find(button => button.dataset.value === hidden.value);
        if (option) selectOption(group, option);
    });

    const initialPropertyGroup = groups.find(group => group.dataset.name === 'tipoInmueble');
    if (initialPropertyGroup) {
        const hiddenKind = initialPropertyGroup.querySelector('input[type="hidden"]');
        const oldPropertyType = propertyType?.value;
        const initialPropertyValue = hiddenKind?.value
            || propertyKindByType[oldPropertyType]
            || (oldPropertyType ? 'otro' : '');

        if (initialPropertyValue) {
            const option = [...initialPropertyGroup.querySelectorAll('.elig-opt')]
                .find(button => button.dataset.value === initialPropertyValue);
            if (option) selectOption(initialPropertyGroup, option);
            updatePropertyType(initialPropertyValue);
        }
    }

    const initialAccessGroup = groups.find(group => group.dataset.name === 'acceso');
    const initialAccessValue = initialAccessGroup?.querySelector('input[type="hidden"]')?.value;
    if (initialAccessGroup && initialAccessValue) {
        const option = [...initialAccessGroup.querySelectorAll('.elig-opt')]
            .find(button => button.dataset.value === initialAccessValue);
        if (option) {
            selectOption(initialAccessGroup, option);
            if (accessType) accessType.value = option.dataset.accessType || '';
        }
    }
})();
