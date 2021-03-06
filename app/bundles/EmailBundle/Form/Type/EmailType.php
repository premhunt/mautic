<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\EmailBundle\Form\Type;

use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\CoreBundle\Form\DataTransformer\IdToEntityModelTransformer;
use Mautic\CoreBundle\Form\EventListener\CleanFormSubscriber;
use Mautic\CoreBundle\Form\EventListener\FormExitSubscriber;
use Mautic\EmailBundle\Helper\PlainTextHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EmailType
 *
 * @package Mautic\EmailBundle\Form\Type
 */
class EmailType extends AbstractType
{

    private $translator;
    private $defaultTheme;
    private $em;
    private $request;

    /**
     * @param MauticFactory $factory
     */
    public function __construct(MauticFactory $factory)
    {
        $this->translator   = $factory->getTranslator();
        $this->defaultTheme = $factory->getParameter('theme');
        $this->em           = $factory->getEntityManager();
        $this->request      = $factory->getRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new CleanFormSubscriber(array('content' => 'html', 'customHtml' => 'html')));
        $builder->addEventSubscriber(new FormExitSubscriber('email.email', $options));

        $variantParent = $options['data']->getVariantParent();
        $isVariant     = !empty($variantParent);

        $builder->add(
            'subject',
            'text',
            array(
                'label'      => 'mautic.email.subject',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array('class' => 'form-control')
            )
        );

        $builder->add(
            'name',
            'text',
            array(
                'label'      => 'mautic.core.name',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array('class' => 'form-control')
            )
        );

        $builder->add(
            'description',
            'textarea',
            array(
                'label'      => 'mautic.core.description',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array('class' => 'form-control editor'),
                'required'   => false
            )
        );

        $builder->add(
            'subject',
            'text',
            array(
                'label'      => 'mautic.email.subject',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array('class' => 'form-control'),
                'required'   => false
            )
        );

        $builder->add(
            'fromName',
            'text',
            array(
                'label'      => 'mautic.email.from_name',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'    => 'form-control',
                    'preaddon' => 'fa fa-user',
                    'tooltip'  => 'mautic.email.from_name.tooltip'
                ),
                'required'   => false
            )
        );

        $builder->add(
            'fromAddress',
            'text',
            array(
                'label'      => 'mautic.email.from_email',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'    => 'form-control',
                    'preaddon' => 'fa fa-envelope',
                    'tooltip'  => 'mautic.email.from_email.tooltip'
                ),
                'required'   => false
            )
        );

        $builder->add(
            'replyToAddress',
            'text',
            array(
                'label'      => 'mautic.email.reply_to_email',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'    => 'form-control',
                    'preaddon' => 'fa fa-envelope',
                    'tooltip'  => 'mautic.email.reply_to_email.tooltip'
                ),
                'required'   => false
            )
        );

        $builder->add(
            'bccAddress',
            'text',
            array(
                'label'      => 'mautic.email.bcc',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'    => 'form-control',
                    'preaddon' => 'fa fa-envelope',
                    'tooltip'  => 'mautic.email.bcc.tooltip'
                ),
                'required'   => false
            )
        );

        $template = $options['data']->getTemplate();
        if (empty($template)) {
            $template = $this->defaultTheme;
        }
        $builder->add(
            'template',
            'theme_list',
            array(
                'feature' => 'email',
                'data'    => $template,
                'attr'    => array(
                    'class'   => 'form-control',
                    'tooltip' => 'mautic.email.form.template.help'
                )
            )
        );

        $builder->add('isPublished', 'yesno_button_group');

        $builder->add(
            'publishUp',
            'datetime',
            array(
                'widget'     => 'single_text',
                'label'      => 'mautic.core.form.publishup',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'       => 'form-control',
                    'data-toggle' => 'datetime'
                ),
                'format'     => 'yyyy-MM-dd HH:mm',
                'required'   => false
            )
        );

        $builder->add(
            'publishDown',
            'datetime',
            array(
                'widget'     => 'single_text',
                'label'      => 'mautic.core.form.publishdown',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'       => 'form-control',
                    'data-toggle' => 'datetime'
                ),
                'format'     => 'yyyy-MM-dd HH:mm',
                'required'   => false
            )
        );

        $builder->add(
            'plainText',
            'textarea',
            array(
                'label'      => 'mautic.email.form.plaintext',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'tooltip'              => 'mautic.email.form.plaintext.help',
                    'class'                => 'form-control',
                    'rows'                 => '15',
                    'data-token-callback'  => 'email:getBuilderTokens',
                    'data-token-activator' => '{'
                ),
                'required'   => false
            )
        );

        $url = $this->request->getSchemeAndHttpHost() . $this->request->getBasePath();
        $builder->addEventListener(FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($url) {
                $parser  = new PlainTextHelper(array(
                    'base_url' => $url
                ));

                $data = $event->getData();

                $data['plainText'] = $parser->setHtml($data['plainText'])->getText();

                $event->setData($data);
            }
        );

        $contentMode = $options['data']->getContentMode();
        if (empty($contentMode)) {
            $contentMode = 'custom';
        }
        $builder->add(
            'contentMode',
            'button_group',
            array(
                'choice_list'        => new ChoiceList(
                    array('custom', 'builder'),
                    array('mautic.email.form.contentmode.custom', 'mautic.email.form.contentmode.builder')
                ),
                'expanded'           => true,
                'multiple'           => false,
                'label'              => 'mautic.email.form.contentmode',
                'empty_value'        => false,
                'required'           => false,
                'data'               => $contentMode,
                'attr'               => array(
                    'onChange' => 'Mautic.onBuilderModeSwitch(this);'
                ),
                'button_group_class' => ''
            )
        );

        $builder->add(
            'customHtml',
            'textarea',
            array(
                'label'    => false,
                'required' => false,
                'attr'     => array(
                    'class' => 'custom-html-content'
                )
            )
        );

        if ($isVariant) {
            $builder->add(
                'variantSettings',
                'emailvariant',
                array(
                    'label' => false
                )
            );
        } else {
            $transformer = new IdToEntityModelTransformer($this->em, 'MauticFormBundle:Form', 'id');
            $builder->add(
                $builder->create(
                    'unsubscribeForm',
                    'form_list',
                    array(
                        'label'       => 'mautic.email.form.unsubscribeform',
                        'label_attr'  => array('class' => 'control-label'),
                        'attr'        => array(
                            'class'            => 'form-control',
                            'tootlip'          => 'mautic.email.form.unsubscribeform.tooltip',
                            'data-placeholder' => $this->translator->trans('mautic.core.form.chooseone')
                        ),
                        'required'    => false,
                        'multiple'    => false,
                        'empty_value' => '',
                    )
                )
                    ->addModelTransformer($transformer)
            );

            //add category
            $builder->add(
                'category',
                'category',
                array(
                    'bundle' => 'email'
                )
            );

            //add lead lists
            $transformer = new IdToEntityModelTransformer($this->em, 'MauticLeadBundle:LeadList', 'id', true);
            $builder->add(
                $builder->create(
                    'lists',
                    'leadlist_choices',
                    array(
                        'label'      => 'mautic.email.form.list',
                        'label_attr' => array('class' => 'control-label'),
                        'attr'       => array(
                            'class' => 'form-control'
                        ),
                        'multiple'   => true,
                        'expanded'   => false,
                        'required'   => false
                    )
                )
                    ->addModelTransformer($transformer)
            );


            $builder->add(
                'language',
                'locale',
                array(
                    'label'      => 'mautic.core.language',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'       => array(
                        'class' => 'form-control'
                    ),
                    'required'   => false,
                )
            );
        }

        $builder->add('sessionId', 'hidden');

        $customButtons = array(
            array(
                'name'  => 'builder',
                'label' => 'mautic.core.builder',
                'attr'  => array(
                    'class'   => 'btn btn-default btn-dnd btn-nospin text-primary',
                    'icon'    => 'fa fa-cube',
                    'onclick' => "Mautic.launchBuilder('emailform', 'email');"
                )
            )
        );

        if (!empty($options['update_select'])) {
            $builder->add(
                'buttons',
                'form_buttons',
                array(
                    'apply_text'        => false,
                    'pre_extra_buttons' => $customButtons
                )
            );
            $builder->add(
                'updateSelect',
                'hidden',
                array(
                    'data'   => $options['update_select'],
                    'mapped' => false
                )
            );
        } else {
            $builder->add(
                'buttons',
                'form_buttons',
                array(
                    'pre_extra_buttons' => $customButtons
                )
            );
        }


        if (!empty($options["action"])) {
            $builder->setAction($options["action"]);
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Mautic\EmailBundle\Entity\Email'
            )
        );

        $resolver->setOptional(array('update_select'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "emailform";
    }
}
