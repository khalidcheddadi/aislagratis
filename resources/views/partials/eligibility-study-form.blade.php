<section class="eligibility-page" aria-labelledby="eligibilityTitle">
    <header class="eligibility-page-heading">
        <span class="eligibility-page-eyebrow"><i class="fa-solid fa-sparkles" aria-hidden="true"></i> Evaluación inicial · Sin compromiso</span>
        <h1 id="eligibilityTitle">¿Tu vivienda puede <span>beneficiarse de los CAE?</span></h1>
        <p>Responde unas preguntas para revisar los datos de tu vivienda. Si quieres, al finalizar puedes enviar la solicitud para que nuestro equipo la estudie.</p>
        <div class="eligibility-page-assurances">
            <span><i class="fa-solid fa-check" aria-hidden="true"></i> Estudio inicial sin compromiso</span>
            <span><i class="fa-solid fa-check" aria-hidden="true"></i> Evaluación técnica posterior</span>
        </div>
    </header>

    @if($errors->any())
        <div class="eligibility-page-errors" role="alert">
            <strong>No se pudo enviar la solicitud.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="eligibility-page-card">
        <div class="eligibility-page-card-top">
            <div>
                <span class="eligibility-page-step-label">Tu evaluación</span>
                <p id="eligibilityStepDescription">Primero, cuéntanos sobre la vivienda y la actuación.</p>
            </div>
            <span class="eligibility-page-step-count"><span id="eligibilityCurrentStep">01</span><span>/ 03</span></span>
        </div>

        <div class="eligibility-page-progress" role="progressbar" aria-label="Progreso del formulario" aria-valuemin="1" aria-valuemax="3" aria-valuenow="1" aria-valuetext="Paso 1 de 3">
            <span class="is-active" data-progress-step="0"></span>
            <span data-progress-step="1"></span>
            <span data-progress-step="2"></span>
        </div>

        <form id="eligibilityForm" method="POST" action="{{ route('leads.store') }}" novalidate>
            @csrf
            <input type="hidden" name="property_type" id="eligibilityPropertyType" value="{{ old('property_type') }}">
            <input type="hidden" name="access_type" id="eligibilityAccessType" value="{{ old('access_type') }}">
            <div class="elig-step active" data-step="0">
                <div class="eligibility-page-step-heading">
                    <span>01</span>
                    <div>
                        <h2>Datos de la vivienda</h2>
                        <p>Cuéntanos qué tipo de inmueble quieres aislar.</p>
                    </div>
                </div>

                <div class="eligibility-page-questions">
                    <fieldset class="elig-opt-group" data-name="propietario" data-required="true">
                        <legend class="eligibility-page-label">¿Eres propietario de la vivienda? <b>*</b></legend>
                        <div class="eligibility-page-options two">
                            <button type="button" class="elig-opt" data-value="Sí"><span class="dot"></span>Sí</button>
                            <button type="button" class="elig-opt" data-value="No"><span class="dot"></span>No</button>
                        </div>
                        <input type="hidden" name="eligibility_owner" value="{{ old('eligibility_owner') }}">
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="tipoInmueble" data-required="true">
                        <legend class="eligibility-page-label">Tipo de inmueble <b>*</b></legend>
                        <div class="eligibility-page-options two">
                            <button type="button" class="elig-opt" data-value="unifamiliar"><span class="dot"></span>Vivienda unifamiliar o chalet</button>
                            <button type="button" class="elig-opt" data-value="piso"><span class="dot"></span>Piso en comunidad de propietarios</button>
                            <button type="button" class="elig-opt" data-value="edificio"><span class="dot"></span>Edificio completo</button>
                            <button type="button" class="elig-opt" data-value="otro"><span class="dot"></span>Otro tipo de inmueble</button>
                        </div>
                        <input type="hidden" name="eligibility_property_kind" value="{{ old('eligibility_property_kind') }}">
                        <div class="eligibility-page-other-type" id="eligibilityOtherType" hidden>
                            <label class="eligibility-page-label" for="eligibilityPropertyTypeOther">Indica el tipo de inmueble <b>*</b></label>
                            <select class="eligibility-page-input" id="eligibilityPropertyTypeOther">
                                <option value="">Selecciona una opción</option>
                                @foreach(\App\Enums\PropertyType::cases() as $type)
                                    <option value="{{ $type->value }}" @selected(old('property_type') === $type->value)>{{ $type->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="zona" data-required="true">
                        <legend class="eligibility-page-label">¿Qué zona quieres aislar? <b>*</b></legend>
                        <div class="eligibility-page-options three">
                            <button type="button" class="elig-opt" data-value="Desván o buhardilla no habitable"><span class="dot"></span>Desván o buhardilla no habitable</button>
                            <button type="button" class="elig-opt" data-value="Bajo cubierta o suelo del ático"><span class="dot"></span>Bajo cubierta o suelo del ático</button>
                            <button type="button" class="elig-opt" data-value="Otra zona"><span class="dot"></span>Otra zona</button>
                        </div>
                        <input type="hidden" name="eligibility_zone" value="{{ old('eligibility_zone') }}">
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="acceso" data-required="true">
                        <legend class="eligibility-page-label">¿Cómo se accede al desván o bajo cubierta? <b>*</b></legend>
                        <div class="eligibility-page-options two">
                            <button type="button" class="elig-opt" data-value="Escalera fija" data-access-type="escalera"><span class="dot"></span>Escalera fija</button>
                            <button type="button" class="elig-opt" data-value="Trampilla o escalera portátil" data-access-type="escalera"><span class="dot"></span>Trampilla o escalera portátil</button>
                            <button type="button" class="elig-opt" data-value="Acceso difícil o pendiente de comprobar"><span class="dot"></span>Acceso difícil o pendiente de comprobar</button>
                            <button type="button" class="elig-opt" data-value="No dispone de acceso" data-access-type="sin_acceso"><span class="dot"></span>No dispone de acceso</button>
                        </div>
                        <input type="hidden" name="eligibility_access" value="{{ old('eligibility_access') }}">
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="habitable" data-required="true">
                        <legend class="eligibility-page-label">¿El desván es habitable? <b>*</b></legend>
                        <div class="eligibility-page-options three">
                            <button type="button" class="elig-opt" data-value="No, es un espacio no habitable"><span class="dot"></span>No, es un espacio no habitable</button>
                            <button type="button" class="elig-opt" data-value="Sí, está acondicionado como vivienda"><span class="dot"></span>Sí, está acondicionado como vivienda</button>
                            <button type="button" class="elig-opt" data-value="No lo sé"><span class="dot"></span>No lo sé</button>
                        </div>
                        <input type="hidden" name="eligibility_habitable" value="{{ old('eligibility_habitable') }}">
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="antiguedad" data-required="true">
                        <legend class="eligibility-page-label">Antigüedad aproximada del inmueble <b>*</b></legend>
                        <div class="eligibility-page-options two">
                            <button type="button" class="elig-opt" data-value="Más de 20 años"><span class="dot"></span>Más de 20 años</button>
                            <button type="button" class="elig-opt" data-value="Entre 10 y 20 años"><span class="dot"></span>Entre 10 y 20 años</button>
                            <button type="button" class="elig-opt" data-value="Menos de 10 años"><span class="dot"></span>Menos de 10 años</button>
                            <button type="button" class="elig-opt" data-value="No lo sé"><span class="dot"></span>No lo sé</button>
                        </div>
                        <input type="hidden" name="eligibility_age" value="{{ old('eligibility_age') }}">
                    </fieldset>

                    <fieldset class="elig-opt-group" data-name="ayudas" data-required="true">
                        <legend class="eligibility-page-label">¿Has recibido ayudas o realizado actuaciones de aislamiento en esta zona durante los últimos 5 años? <b>*</b></legend>
                        <div class="eligibility-page-options three">
                            <button type="button" class="elig-opt" data-value="No"><span class="dot"></span>No</button>
                            <button type="button" class="elig-opt" data-value="Sí"><span class="dot"></span>Sí</button>
                            <button type="button" class="elig-opt" data-value="No lo sé"><span class="dot"></span>No lo sé</button>
                        </div>
                        <input type="hidden" name="eligibility_aid" value="{{ old('eligibility_aid') }}">
                    </fieldset>
                </div>

                <div class="eligibility-page-actions">
                    <span class="eligibility-page-required">* Campos obligatorios</span>
                    <button type="button" class="eligibility-page-next" data-elig-next>Siguiente <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>

            <div class="elig-step" data-step="1">
                <div class="eligibility-page-step-heading">
                    <span>02</span>
                    <div>
                        <h2>Tus datos de contacto</h2>
                        <p>Los utilizaremos para estudiar tu solicitud.</p>
                    </div>
                </div>

                <div class="eligibility-page-contact-grid">
                    <div>
                        <label class="eligibility-page-label" for="el-nombre">Nombre <b>*</b></label>
                        <input class="eligibility-page-input" id="el-nombre" name="first_name" type="text" required autocomplete="given-name" value="{{ old('first_name') }}" placeholder="Tu nombre">
                    </div>
                    <div>
                        <label class="eligibility-page-label" for="el-apellidos">Apellidos <b>*</b></label>
                        <input class="eligibility-page-input" id="el-apellidos" name="last_name" type="text" required autocomplete="family-name" value="{{ old('last_name') }}" placeholder="Tus apellidos">
                    </div>
                    <div>
                        <label class="eligibility-page-label" for="el-email">Email <b>*</b></label>
                        <input class="eligibility-page-input" id="el-email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" placeholder="tu@email.com">
                    </div>
                    <div>
                        <label class="eligibility-page-label" for="el-telefono">Teléfono de contacto <b>*</b></label>
                        <input class="eligibility-page-input" id="el-telefono" name="phone" type="tel" required maxlength="30" pattern="[0-9\s\+\-\(\)]{6,30}" autocomplete="tel" value="{{ old('phone') }}" placeholder="600 000 000">
                    </div>
                </div>

                <fieldset class="elig-opt-group eligibility-page-contact-choice" data-name="whatsappPref" data-required="true">
                    <legend class="eligibility-page-label">¿Podemos contactarte por WhatsApp? <b>*</b></legend>
                    <div class="eligibility-page-options three">
                        <button type="button" class="elig-opt" data-value="Sí, prefiero WhatsApp"><span class="dot"></span>Sí, prefiero WhatsApp</button>
                        <button type="button" class="elig-opt" data-value="Sí, llamada o WhatsApp"><span class="dot"></span>Sí, llamada o WhatsApp</button>
                        <button type="button" class="elig-opt" data-value="No, solo llamadas"><span class="dot"></span>No, solo llamadas</button>
                    </div>
                    <input type="hidden" name="eligibility_contact_preference" value="{{ old('eligibility_contact_preference') }}">
                </fieldset>

                <div class="eligibility-page-actions">
                    <button type="button" class="eligibility-page-back" data-elig-prev><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Anterior</button>
                    <button type="button" class="eligibility-page-next" data-elig-next>Siguiente <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>

            <div class="elig-step" data-step="2">
                <div class="eligibility-page-step-heading">
                    <span>03</span>
                    <div>
                        <h2>Ubicación del inmueble</h2>
                        <p>Necesitamos estos datos para valorar la actuación.</p>
                    </div>
                </div>

                <div class="eligibility-page-contact-grid">
                    <div class="eligibility-page-field-wide">
                        <label class="eligibility-page-label" for="el-direccion">Dirección completa <b>*</b></label>
                        <input class="eligibility-page-input" id="el-direccion" name="address" type="text" required autocomplete="street-address" value="{{ old('address') }}" placeholder="Calle, número, piso">
                    </div>
                    <div>
                        <label class="eligibility-page-label" for="el-cp">Código postal <b>*</b></label>
                        <input class="eligibility-page-input" id="el-cp" name="postal_code" type="text" required inputmode="numeric" pattern="[0-9]{5}" maxlength="5" autocomplete="postal-code" value="{{ old('postal_code') }}" placeholder="28001">
                    </div>
                    <div>
                        <label class="eligibility-page-label" for="el-ciudad">Ciudad o municipio <b>*</b></label>
                        <input class="eligibility-page-input" id="el-ciudad" name="city" type="text" required autocomplete="address-level2" value="{{ old('city') }}" placeholder="Tu ciudad">
                    </div>
                    <div class="eligibility-page-field-wide">
                        <label class="eligibility-page-label" for="el-catastral">Referencia catastral <span>(opcional)</span></label>
                        <input class="eligibility-page-input" id="el-catastral" name="cadastral_reference" type="text" maxlength="30" value="{{ old('cadastral_reference') }}" placeholder="Referencia catastral">
                    </div>
                    <div class="eligibility-page-field-wide">
                        <label class="eligibility-page-label" for="el-comentario">Comentarios adicionales <span>(opcional)</span></label>
                        <textarea class="eligibility-page-input" id="el-comentario" name="message" rows="3" maxlength="2000" placeholder="Cuéntanos cualquier detalle relevante...">{{ old('message') }}</textarea>
                    </div>
                </div>

                <label class="eligibility-page-privacy" for="el-privacidad">
                    <input type="checkbox" name="privacy" id="el-privacidad" value="1" required @checked(old('privacy'))>
                    <span>He leído y acepto la <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener">política de privacidad</a> y el tratamiento de mis datos para gestionar esta solicitud. <b>*</b></span>
                </label>

                <p class="eligibility-page-disclaimer">La evaluación inicial no garantiza la concesión de CAE. La viabilidad se confirmará tras revisar los requisitos técnicos y la documentación correspondiente.</p>

                <div class="eligibility-page-actions">
                    <button type="button" class="eligibility-page-back" data-elig-prev><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Anterior</button>
                    <button type="submit" class="eligibility-page-submit">Enviar solicitud <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>

            @if(old('service_id', request('service_id')))
                <input type="hidden" name="service_id" value="{{ old('service_id', request('service_id')) }}">
            @endif
        </form>
    </div>

    <p class="eligibility-page-footnote"><i class="fa-solid fa-lock" aria-hidden="true"></i> Tus datos se utilizarán únicamente para gestionar y valorar esta solicitud.</p>
</section>
