<?php

/**
 * @file
 * Contains \Drupal\material\Form\MaterialForm.
 */
namespace Drupal\material\Form;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Xss;
use Symfony\Component\HttpFoundation\Response;
/**
 * material form
 * 
 */
class MaterialForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'material_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['city'] = array(
            '#type' => 'textfield',
            '#title' => t('City:'),
            '#required' => TRUE,
            '#maxlength' => '125',
            //'#attributes' => array('placeholder' => t('Enter Your Name Here')),
            '#default_value' => '',
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['#attributes']['class'] =array(
                '',
            );
        $form['actions']['submit'] = array(
                '#type' => 'submit',
                '#value' => $this->t('Submit'),
                '#button_type' => 'primary',
                
            );

        return $form;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }
    
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $city = Xss::filterAdmin(trim($form_state->getValue('city')));
        if(!empty($city)) {
            $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=8a2af78e7b4a955aefaad7fe8ce98b07&units=metric';
            //$response = \Drupal::httpClient()->get($url, array('headers' => array('Accept' => 'application/json')));
            $response = \Drupal::httpClient()->get($url);
            $data = (string) $response->getBody();
            print_r($data);die;
        }
    }
}
