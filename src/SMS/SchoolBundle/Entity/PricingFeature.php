<?php

namespace SMS\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * PricingFeature
 *
 * @ORM\Table(name="pricing_feature")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="SMS\SchoolBundle\Repository\PricingFeatureRepository")
 * @Gedmo\TranslationEntity(class="SMS\SchoolBundle\Entity\Translations\PricingFeatureTranslation")
 */
class PricingFeature
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=100)
     * @Gedmo\Translatable
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="boolean", length=100)
     */
    private $state;

    /**
     * One Pricing has Many Pricing Features.
     * @ORM\ManyToOne(targetEntity="Pricing" , inversedBy="pricingFeature" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="pricing_id", referencedColumnName="id")
     */
    private $pricing;

    /**
     * One User has Many Pricing Features.
     * @ORM\ManyToOne(targetEntity="SMS\UserBundle\Entity\User" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;

    /**
     * @var ArrayCollection
     * * @Assert\Valid(deep = true)
     * @ORM\OneToMany(targetEntity="SMS\SchoolBundle\Entity\Translations\PricingFeatureTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get translations.
     *
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Add translation.
     *
     * @param PostTranslation $translation
     *
     * @return $this
     */
    public function addTranslation($translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }
     /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdated(new \DateTime('now'));

        if ($this->getCreated() == null) {
            $this->setCreated(new \DateTime('now'));
        }
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set featureName
     *
     * @param string $featureName
     *
     * @return PricingFeature
     */
    public function setFeatureName($featureName)
    {
        $this->featureName = $featureName;

        return $this;
    }

    /**
     * Get featureName
     *
     * @return string
     */
    public function getFeatureName()
    {
        return $this->featureName;
    }

    /**
     * Set user
     *
     * @param \SMS\UserBundle\Entity\User $user
     *
     * @return PricingFeature
     */
    public function setUser(\SMS\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SMS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return PricingFeature
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return PricingFeature
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PricingFeature
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return PricingFeature
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set pricing
     *
     * @param \SMS\SchoolBundle\Entity\Pricing $pricing
     *
     * @return PricingFeature
     */
    public function setPricing(\SMS\SchoolBundle\Entity\Pricing $pricing = null)
    {
        $this->pricing = $pricing;

        return $this;
    }

    /**
     * Get pricing
     *
     * @return \SMS\SchoolBundle\Entity\Pricing
     */
    public function getPricing()
    {
        return $this->pricing;
    }
}
