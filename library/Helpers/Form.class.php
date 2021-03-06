<?php
/**
 * Form.class [ HELPER ]
 * Classe responável por gerar formulários!
 * 
 * @copyright (c) 2014, Leo Bessa
 */
class Form {

    private static $classes;
    private static $label;
    private static $place;
    private static $info;
    private static $icon;
    private static $lado;
    private static $type;
    private static $id;
    private static $idForm;
    private static $values;
    private static $valor;
    private static $options;
    private static $label_options;
    private static $style;
    private static $tamanhoForm;
    private static $tamanho;
    private static $action;
    public  static $form;
    public  static $botao;
    

    
    /**
     * <b>setClasses:</b> ionicia o formulário e suas configurações
     * @param STRING $idform: atribui o ID para o Formulário
     */
    function __construct($idform, $action,$botao = "Salvar",$tamanhoForm = 6) {
        self::$idForm            = $idform;
        self::$style             = "";
        self::$type              = "text";
        self::$options           = array();
        self::$label_options     = array();
        self::$form              = "";
        self::$tamanhoForm       = $tamanhoForm;
        self::$tamanho           = "";
        self::$action            = $action;
        self::$botao             = $botao;
    }
    
    /**
     * <b>setClasses:</b> Atribui as classes para os campos.
     * @param STRING $classes: Essas classes podem ser utilizadas par formação de CSS,
     * para atribuir a eventos de JQUERY, e calsses de validações. EX: (cpf ob moeda).
     */
    public function setClasses($classes) {
        self::$classes = $classes;
        return $this;
    }
    
    /**
     * <b>setLabel:</b> Atribui o label a ser apresentado para todos os tipos de campo.
     * @param STRING $label.
     */
    public function setLabel($label) {
        self::$label = $label;
        return $this;
    }
    
    /**
     * <b>setValues:</b> Atribui o valor para os campos
     * @param STRING $values. pode ser utilizados para todos os inputs e textearea.
     */
    public function setValues($values) {
        self::$values = $values;
        return $this;
    }
    
    /**
     * <b>setValues:</b> Atribui o valor para os campos
     * @param STRING $values. pode ser utilizados para todos os inputs e textearea.
     */
    public function setValor($valor) {
        self::$valor = $valor;
        return $this;
    }
    
    /**
     * <b>setValues:</b> Atribui o valor para os campos
     * @param STRING $values. pode ser utilizados para todos os inputs e textearea.
     */
    public function setTamanhoInput($tamanho) {
        self::$tamanho = $tamanho;
        return $this;
    }
    
    /**
     * <b>setType:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $type: password, file, select, textarea, radio, checkbox, hidden e o text.
     */
    public function setType($type) {
        self::$type = $type;
        return $this;
    }
    
     /**
     * <b>setPlace:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $type: password, file, select, textarea, radio, checkbox, hidden e o text.
     */
    public function setPlace($place) {
        self::$place = $place;
        return $this;
    }
    
     /**
     * <b>setInfo:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $type: password, file, select, textarea, radio, checkbox, hidden e o text.
     */
    public function setInfo($info) {
        self::$info = $info;
        return $this;
    }
    
     /**
     * <b>setIcon:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $type: password, file, select, textarea, radio, checkbox, hidden e o text.
     */
    public function setIcon($icon,$lado = "esq") {
        self::$icon = $icon;
        self::$lado = $lado;
        return $this;
    }
        
    /**
     * <b>setId:</b> Atribui o ID e o NAME do input
     * @param STRING $id.
     */
    public function setId($id) {
        self::$id = $id;
        return $this;
    }
    
//    /**
//     * <b>setStylo:</b> Atribui os Stylo (CSS) para o input
//     * @param ARRAY $stylo. define propriedade de CSS para stylo (Propriedade: Atributo) 
//     * Ex.: array ('border' => '1px solid red', 'color' => 'black')
//     */
//    public function setStylo(array $stylo) { 
//        if (!empty($stylo)):             
//            foreach ($stylo as $key => $value) {
//                self::$style .= "$key: $value; ";
//            }
//        endif;
//        return $this;        
//    }
//    
    /**
     * <b>setId:</b> Pega no banco de dados os registros para o autocomplete.
     * @param STRING $tabela: nome da tabela a ser consultada.
     * @param STRING $campo: nome do campo a ser consultado.
     * @return ARRAY script: gera o script para o autocomplete
     */
//    public function setAutocomplete($tabela,$campo) {
//        if (self::$id != ""):
//            $autocomplete = new Pesquisa();        
//            $autocomplete->Pesquisar($tabela,"ORDER BY $campo");
//
//            self::$form  .=  "<script>$(document).ready(function(){var nomes = [";
//
//            if ($autocomplete->getResult()){
//                    foreach ($autocomplete->getResult() as $res){                    
//                            self::$form  .=  '"'.$res[$campo].'",';
//                    }
//            }
//            self::$form  .=  "];$('#".self::$id."').autocomplete({source: nomes});});</script>";
//        else:
//            self::$form  .=  "Não tem id o autocomplete";
//        endif;
//        return $this;   
//    }
    /**
     * <b>setId:</b> Pega no banco de dados os registros para o autocomplete.
     * @param STRING $tabela: nome da tabela a ser consultada.
     * @param STRING $campo: nome do campo a ser consultado.
     * @return ARRAY script: gera o script para o autocomplete
     */
    public function setAutocomplete($tabela,$campo,$id) {
        
            $autocomplete = new Pesquisa();        
            $autocomplete->Pesquisar($tabela,"ORDER BY $campo",NULL,$id.','.$campo);
            $dados[""] = "Selecione um item";
            if ($autocomplete->getResult()){
                    foreach ($autocomplete->getResult() as $res){                    
                            $dados[$res[$id]]  =  $res[$campo];
                    }
                    self::$options = $dados;
            }
        return $this;   
    }
    
    /**
     * <b>setOptions:</b> Atribui os valores das options a montar um select
     * @param ARRAY $options: O indece do array se torna o value da option e o valor do array se torna o label a ser apresentado..  
     */
    public function setOptions($options) {
        self::$options = (array) $options;
        return $this;
    }
    
    /**
     * <b>setLabelCheckRadio:</b> Atribui os valores dos label para checkbox e radiobuttom.
     * @param ARRAY $label_options: Cada indice do array se torna uma opção dos  checkbox ou radiobuttom
     */
     public function setLabelCheckRadio($label_options) {
        self::$label_options = (array) $label_options;
        return $this;
    }
    
    private function verificaObrigatoriedade(){
        if(self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if(in_array("ob", $ob)):
             $obrigatoriedade = ' <span class="symbol required"></span>';
            else:
             $obrigatoriedade = "";
            endif;
        else:
             $obrigatoriedade = "";
        endif;        
       
        return $obrigatoriedade;
    }
    
    private function verificaInline(){
        $inline = array();
        if(self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if(in_array("inline", $ob)):
                $inline['inicio'] = '<label class="'.self::$type.'-inline">';
                $inline['fim'] = '</label>';
                unset($ob['inline']);
                self::$classes = implode(" ", $ob);
            else:
                $inline['inicio'] = '<div class="'.self::$type.'">'
                                        . '<label>';
                $inline['fim'] = '</label>'
                        . '</div>';
            endif;
        else:
                $inline['inicio'] = '<div class="'.self::$type.'">'
                                        . '<label>';
                $inline['fim'] = '</label>'
                        . '</div>';
        endif;        
       
        return $inline;
    }
    
    private function verificaMultiplo(){       
        if(self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if(in_array("multipla", $ob)):
                $multiplo = "multiple='multiple'";                
                unset($ob['multiplo']);
                self::$classes = implode(" ", $ob);
            else:
                $multiplo = "";
            endif;
        else:
                $multiplo = "";
        endif;        
       
        return $multiplo;
    }

       
    private function verificaChecked(){       
        if(self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if(in_array("checked", $ob)):
                $checked = 'checked="checked"';                
                unset($ob['checked']);
                self::$classes = implode(" ", $ob);
            else:
                $checked = "";
            endif;
        else:
                $checked = "";
        endif;        
       
        return $checked;
    }

     /**
     * <b>CriaInpunt:</b> Cria os inputs do formulário
     * @return STRING com o campo criado.  
     */
    public function CriaInpunt(){    
        // VALIDA CAMPOS OCUILTOS
        if(self::$type != "hidden"):
            // VALIDA TAMANHO DO GRUPO DO INPUT
             if(self::$tamanho != ""):
                 self::$form  .=  '<div class="col-sm-'.self::$tamanho.'" style="padding:0px 2px;">';
             endif;
             // VERIFICA SE TEM OBRIGATORIEDADE O CAMPO.
             $obrigatoriedade = $this->verificaObrigatoriedade();
             // INICIA O GRUPO DO INPUT               
            self::$form  .=  '<div class="form-group">'
                            . '<label for="'.self::$id.'" class="control-label">'
                    . ' '.  self::$label.$obrigatoriedade.''
                    . '</label>'; 
                     // VERIFICA SE TEM ÍCONE
                     if(self::$icon != ""):
                         self::$form  .=  '<div class="input-group '.self::$id.'">';
                                            // VERIFICA O LADO DO ÍCONE
                                            if(self::$lado == "esq"):
                                               self::$form  .= '<span class="input-group-addon" style="height: 34px;">'
                                                                 . '<i class="'.self::$icon.'"></i></span>';
                                            endif;
                        endif;
                     //VERIFICA SE TEM PLACEHOLDER
                     if(self::$place != ""):
                         self::$place = ' placeholder="'.self::$place.'"';
                     endif;
             
             //CAMPO TIPO SELECT        
             if(self::$type == "select"):
                 $mutiplo = $this->verificaMultiplo();
                 self::$form  .=  "<select ".$mutiplo.self::$place." id='".self::$id."' name='".self::$id."[]' class='form-control search-select ".self::$classes."'>";
                    foreach (self::$options as $key => $values):
                            $checked = "";
                            if(!empty(self::$valor[self::$id])):
                                if($key == self::$valor[self::$id]):
                                    $checked = 'selected';
                                endif;
                            endif;
                            self::$form  .=  '<option value="'.$key.'" '.$checked.'>'.$values.'</option>';
                    endforeach;
                self::$form  .=  "</select>";
             
             //CAMPO TIPO TEXTAREA      
             elseif(self::$type == "textarea"): 
                 if(!empty(self::$valor)):
                     $texto = self::$valor[self::$id];
                 else:
                     $texto = "";
                 endif;
                  self::$form  .=  "<textarea id='".self::$id."' name='".self::$id."'".self::$place." style='resize: none;' class='form-control ".self::$classes."' >".$texto."</textarea>";
             
             //CAMPO TIPO FILE (ARQUIVO)   
             elseif(self::$type == "file"):
                 $mutiplo = $this->verificaMultiplo();
                 self::$form  .=  '<div class="fileupload fileupload-new" data-provides="fileupload" style="margin-bottom: 0px;">
                                    <div class="input-group">
                                            <div class="form-control uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                            </div>
                                            <div class="input-group-btn">
                                                    <div class="btn btn-dark-grey btn-file">
                                                            <span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Selecionar Arquivo</span>
                                                            <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Trocar</span>
                                                            <input '.$mutiplo.' type="file" class="file-input '.self::$classes.'" id="'.self::$id.'" name="'.self::$id.'[]" />
                                                    </div>
                                                    <a href="#" class="btn btn-bricky fileupload-exists" data-dismiss="fileupload">
                                                            <i class="fa fa-trash-o"></i> Remover
                                                    </a>
                                            </div>
                                    </div>
                            </div>';
            
             // CAMPO TIPO RADIO OU CHECKBOX
             elseif(self::$type == "radio" || self::$type == "checkbox"):
                 
                 self::$form  .=  "</label><br/>";
             
                 if(self::$type == "checkbox" && !empty(self::$options)):
                     $cor = array("branco" => "default", "azul" => "primary", "verde" => "success", "vermelho" => "danger", "amarelo" => "warning");
                     $verifcaChecked = $this->verificaChecked();
                     self::$form  .=  '<div id="change-color-switch" class="make-switch" data-on-label="'.self::$options[0].'" data-off-label="'.self::$options[1].'" data-on="'.$cor[self::$options[2]].'" data-off="'.$cor[self::$options[3]].'">
                                            <input type="checkbox" '.$verifcaChecked.' id="'.self::$id.'" name="'.self::$id.'"  class="'.self::$classes.'"/>
                                    </div>';
                 else:
                     foreach (self::$label_options as $key => $op):
                        if(!empty(self::$valor)):
                            $valor = self::$valor[self::$id];
                        else:
                            $valor = "";
                        endif;
                        
                        $verifcaInputs = $this->verificaInline();

                        self::$form  .= $verifcaInputs['inicio'];
                        if($valor == $key):
                           $verifcaChecked = " checked='checked'";
                        else:
                            $verifcaChecked = "";
                        endif;
                        self::$form  .=  " <input id='".self::$id."'".$verifcaChecked." name='".self::$id."' value='".$key."'  class='flat-black ".self::$classes."' type='".self::$type."' />"
                          .$op;
                        self::$form  .= $verifcaInputs['fim'];
                     endforeach;

                 endif;
             else:
                 if(!empty(self::$valor)):
                    if(array_key_exists(self::$id, self::$valor)):
                        $valor = self::$valor[self::$id];
                    else:
                         $valor = "";
                    endif;                        
                 else:
                     $valor = "";
                 endif;
                 //CAMPO TIPO TEXT
                 self::$form  .=  '<input type="'.self::$type.'"'.self::$place.' class="form-control '.self::$classes.'" id="'.self::$id.'" name="'.self::$id.'" value="'.$valor.'"/>';         
             endif;
            
             // VERIFICA SE TEM ÍCONE
             if(self::$icon != ""):
                     // VERIFICA SE O ÍCONE É DO LADO DIREITO
                     if(self::$lado == "dir"):
                        self::$form  .= '<span class="input-group-addon">'
                                        . '<i class="'.self::$icon.'"></i></span>';
                     endif;
                  
                  // FECHA DIV DO ÍCONE
                  self::$form  .=   '</div>';
             endif;
             
             // VERIFICA SE TEM INFORMAÇÃO
             if(self::$info != ""):        
                  self::$form  .=  '<span class="help-block" id="'.self::$id.'-info"><i class="fa fa-info-circle"></i> '.self::$info.'</span>';
             else:
                  self::$form  .=  '<span class="help-block" id="'.self::$id.'-info">.</span>';
             endif;
             
              // FECHA O TAMANHO DO INPUT
              if(self::$tamanho != ""):
                 self::$form  .=   '</div>';
              endif;
             
             // FECHA O GRUPO DO INPUT
             self::$form  .=   '</div>';
        else:
            
            // CAMPO TIPO HIDDEN
            self::$form  .=  '<input id="'.self::$id.'" name="'.self::$id.'" value="'.self::$values.'" type="hidden" />';
        endif;
        
        // ZERA TODOS OS ATRIBUTOS
        self::$type             = "text";
        self::$values           = "";
        self::$classes          = "";
        self::$id               = "";
        self::$label            = "";        
        self::$style            = "";
        self::$place            = "";
        self::$info             = "";
        self::$icon             = "";
        self::$tamanho          = "";
        self::$label_options    = array();
        self::$options          = array();
    }
    
    /**
     * <b>finalizaForm:</b> Fecha o formulário
     * @return STRING com o fechamento do FORM.  
     */
    public function finalizaForm() {
        self::$form  =  '<div class="col-sm-'.self::$tamanhoForm.'">							
                <div class="panel panel-box">
                        <div class="panel-body">
                            <form action="'.HOME.self::$action.'" role="form" id="'.self::$idForm.'" name="'.self::$idForm.'" method="post"  enctype="multipart/form-data" class="formulario">                                                         
                            <div class="col-md-12">'.
                            self::$form
                    .'<button data-style="zoom-out" class="btn btn-success ladda-button" type="submit" value="'.self::$idForm.'" name="'.self::$idForm.'" style="margin-top: 10px;">
                                <span class="ladda-label"> '.self::$botao.' </span>
                                <i class="fa fa-save"></i>
                                <span class="ladda-spinner"></span>
                            </button>
                            <button data-style="expand-right" class="btn btn-danger ladda-button" type="reset" style="margin-top: 10px;">
                                <span class="ladda-label"> Limpar </span>
                                <i class="fa fa-ban"></i>
                                <span class="ladda-spinner"></span>
                            </button>
                    </div>
                </form>
             </div>
        </div>';
           
        return self::$form;
    }
    

}
