<?php

namespace Config;

class Forms {

    public function formI ($method, $action = '', $name = ''){
        return '<form method="'.$method.'" action="'.$action.'" name="'.$name.'">';
    }

    public function formF (){
        return '</form>';
    }

    public function label ($for, $text, $class = ''){
        return '<label for="'.$for.'" class="'.$class.'">'.$text.'</label>';
    }

    public function input (string $type ,string $name, string $id, string $value = '', string $placeholder = '', string $class = '', $maxlenght = '', bool $required = false){
        
        $requiredAttr = $required ? 'required' : '';

        return '<input class="'.$class.'" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" placeholder="'.$placeholder.'", maxlength="'.$maxlenght.'" '.$requiredAttr.' >';
    }

    public function inputTel (string $type, $name, $id, $value, $pattern, $maxlenght, $class, bool $required = false){

        $requiredAttr = $required ? 'required' : '';

        return '<input type="'.$type.'" pattern="'.$pattern.'" maxlength="'.$maxlenght.'" class="'.$class.'" id="'.$id.'" value="'.$value.'" name="'.$name.'" '.$requiredAttr.'>';
    }

    public function inputChecked (string $type ,string $name, string $id, $checked, string $value = '', string $class = '', bool $required = false){

        $requiredAttr = $required ? 'required' : '';

        return '<input class="'.$class.'" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$checked.' '.$requiredAttr.' >';
    }

    public function button ($type, $name, $id, $classBT, $classI, $text){
        return '<button type="'.$type.'" name="'.$name.'" id="'.$id.'" class="'.$classBT.'">
                    <i class="'.$classI.'"></i> '.$text.'
                </button>';
    }

    public function buttonOnclick ($type, $name, $id, $classBT, $classI, $text, $onClick){
        return '<button type="'.$type.'" name="'.$name.'" id="'.$id.'" class="'.$classBT.'" onclick="'.$onClick.'">
                    <i class="'.$classI.'"></i> '.$text.'
                </button>';
    }

    public function inputSelect(
        string $name,
        string $id,
        array $options,
        string $valueKey,
        string $labelKey,
        string $selectedValue = '',
        string $class = 'form-select',
        bool|string $required = false,
        bool|string $autoSubmit = false,
        string $placeholder = 'Selecione uma opção...'
    ) {
        // required
        $requiredAttr = $required === true ? 'required' : '';

        // onchange
        if ($autoSubmit === true) {
            $onChangeAttr = 'onchange="this.form.submit()"';
        } elseif (is_string($autoSubmit) && $autoSubmit !== '') {
            $onChangeAttr = 'onchange="'.$autoSubmit.'"';
        } else {
            $onChangeAttr = '';
        }

        $html  = '<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$onChangeAttr.' '.$requiredAttr.'>';

        if ($placeholder !== '') {
            $html .= '<option value="">'.$placeholder.'</option>';
        }

        foreach ($options as $key => $option) {

            // 🔹 Caso 1: array associativo (id => nome)
            if (!is_array($option)) {
                $value = $key;
                $label = $option;
            }
            // 🔹 Caso 2: array de arrays
            else {
                $value = $option[$valueKey];
                $label = $option[$labelKey];
            }

            $selected = ((string)$value === (string)$selectedValue) ? 'selected' : '';

            $html .= '<option value="'.htmlspecialchars($value, ENT_QUOTES, 'UTF-8').'" '.$selected.'>'
                . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') .
                '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    // Botão para drawer
    public function buttonDrawer($data_drawer, $data_url, $data_title, $class_bt, $icon_class, $text, $title = '') {

        return '<button
                    type="button"
                    class="'.$class_bt.' open-drawer"
                    data-drawer="#'.trim($data_drawer).'"
                    data-url="'.$data_url.'"
                    data-title="'.$data_title.'"
                    title="'.$title.'"
                >
                    <i class="'.$icon_class.'"></i>
                    '.$text.'
                </button>';

    }
    
    // Início do drawer
    public function drawerI($id, $class, $drawerName, $drawerColse) {

        return '<div
                    id="'.$id.'"
                    class="'.$class.'"
                    data-kt-drawer="true"
                    data-kt-drawer-name="'.$drawerName.'"
                    data-kt-drawer-overlay="true"
                    data-kt-drawer-width="{default:\'100%\', lg:\'70%\'}"
                    data-kt-drawer-direction="end"
                    data-kt-drawer-container="body"
                    data-kt-drawer-close="#'.$drawerColse.'"
                >';

    }

    // Fim do drawer
    public function drawerF() {
        return '</div>';
    }

    // Inicio do aside (sidebar)
    public function asideI($id, $class, $style = '') {
        $styleAttr = $style ? 'style="'.$style.'"' : '';
        return '<aside id="'.$id.'" class="'.$class.' relative" '.$styleAttr.'>';
    }

    public function asideF() {
        return '
            <button id="toggle-btn-sidebar" 
                    onclick="toggleSidebar()" 
                    class="absolute top-1/2 transform -translate-y-1/2 z-[100] 
                        bg-white border border-gray-200 rounded-full p-2 shadow-lg 
                        hover:bg-gray-50 transition-all duration-300 focus:outline-none"
                    style="right: -15px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                <i class="ki-filled ki-double-left text-gray-600 text-[10px] transition-transform duration-300" id="sidebar-toggle-icon"></i>
            </button>
        </aside>';
    }
}