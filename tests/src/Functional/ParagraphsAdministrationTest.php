<?php

namespace Drupal\Tests\localgov_paragraphs\Functional;

use Drupal\Tests\paragraphs\Functional\Classic\ParagraphsTestBase;

/**
 * Tests the configuration of localgov_paragraphs.
 */
class ParagraphsAdministrationTest extends ParagraphsTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'paragraphs',
    'localgov_paragraphs',
  ];

  /**
   * Tests the LocalGovDrupal core paragraph types.
   */
  public function testParagraphsTypes() {
    $this->loginAsAdmin([
      'administer paragraphs types',
    ]);

    // Check paragraph types installed.
    $this->drupalGet('/admin/structure/paragraphs_type');
    $this->assertSession()->pageTextContains('advanced_links');
    $this->assertSession()->pageTextContains('contact');
    $this->assertSession()->pageTextContains('localgov_image');
    $this->assertSession()->pageTextContains('pagebuilder_text');

    // Check advanced_links paragraph fields.
    $this->drupalGet('/admin/structure/paragraphs_type/advanced_links/fields');
    $this->assertSession()->pageTextContains('field_title');
    $this->assertSession()->pageTextContains('field_url');

    // Check contact paragraph fields.
    $this->drupalGet('/admin/structure/paragraphs_type/contact/fields');
    $this->assertSession()->pageTextContains('field_para_contact_address');
    $this->assertSession()->pageTextContains('field_para_contact_url');
    $this->assertSession()->pageTextContains('field_para_contact_email');
    $this->assertSession()->pageTextContains('field_para_contact_facebook');
    $this->assertSession()->pageTextContains('field_para_contact_heading');
    $this->assertSession()->pageTextContains('field_para_contact_instagram');
    $this->assertSession()->pageTextContains('field_para_contact_location');
    $this->assertSession()->pageTextContains('field_para_contact_minicom');
    $this->assertSession()->pageTextContains('field_para_contact_mobile');
    $this->assertSession()->pageTextContains('field_para_contact_office_hours');
    $this->assertSession()->pageTextContains('field_para_contact_other_social');
    $this->assertSession()->pageTextContains('field_para_contact_other_url');
    $this->assertSession()->pageTextContains('field_para_contact_out_of_hours');
    $this->assertSession()->pageTextContains('field_para_contact_phone');
    $this->assertSession()->pageTextContains('field_para_contact_subheading');
    $this->assertSession()->pageTextContains('field_para_contact_twitter');

    // Check pagebuilder_image paragraph fields.
    $this->drupalGet('/admin/structure/paragraphs_type/localgov_image/fields');
    $this->assertSession()->pageTextContains('field_caption');
    $this->assertSession()->pageTextContains('field_image');

    // Check pagebuilder_text paragraph fields.
    $this->drupalGet('/admin/structure/paragraphs_type/pagebuilder_text/fields');
    $this->assertSession()->pageTextContains('field_text');
  }

  /**
   * Tests the paragraph creation.
   */
  public function testParagraphsCreation() {
    // Create an node type with paragraphs field.
    $this->addParagraphedContentType('paragraphs', 'field_paragraphs', 'entity_reference_paragraphs');
    $this->loginAsAdmin([
      'administer site configuration',
      'create paragraphs content',
      'administer nodes',
    ]);

    // Add a new paragraph node with a pagebuilder_text paragraph field.
    $this->drupalGet('node/add/paragraphs');
    $this->drupalPostForm(NULL, [], 'field_paragraphs_pagebuilder_text_add_more');
    $edit = [
      'title[0][value]' => 'Test',
      'field_paragraphs[0][subform][field_text][0][value]' => 'Test paragraph text',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertSession()->pageTextContains('has been created');
    $this->assertSession()->pageTextContains('Test paragraph text');
  }

}
