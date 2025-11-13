<?php
require_once '../config/config.php';
$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo META_KEYWORDS; ?>">
    <title>Delegate Registration - <?php echo SITE_NAME; ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 1rem;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .form-wrapper {
            padding: 1.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required {
            color: #dc3545;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .radio-option,
        .checkbox-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        input[type="radio"],
        input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .hidden {
            display: none;
        }

        .delegation-members {
            margin-top: 1rem;
        }

        .member-card {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 3px solid #667eea;
        }

        .member-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .member-title {
            font-weight: 600;
            color: #667eea;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-add {
            background: #28a745;
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            margin-top: 1rem;
        }

        /* Tablet and Desktop */
        @media (min-width: 768px) {
            body {
                padding: 2rem;
            }

            .container {
                max-width: 800px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-wrapper {
                padding: 2.5rem;
            }

            .form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.25rem;
            }

            .form-grid-full {
                grid-column: 1 / -1;
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 900px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo EVENT_NAME; ?> Registration</h1>
            <p><?php echo EVENT_DATE; ?> | <?php echo EVENT_VENUE; ?></p>
        </div>

        <div class="form-wrapper">
            <?php
            $alert = getAlert();
            if ($alert):
            ?>
            <div class="alert alert-<?php echo $alert['type']; ?>">
                <?php echo $alert['message']; ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL; ?>register?action=submit" id="registrationForm">
                
                <!-- Registration Type -->
                <div class="form-section">
                    <h2 class="form-section-title">Registration Type</h2>
                    
                    <div class="form-group">
                        <label>Are you from NED University? <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" name="registration_type" value="NED" id="type_ned" required>
                                <label for="type_ned">NED Student</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="registration_type" value="Other" id="type_other" required>
                                <label for="type_other">External Participant</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Participant Type <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" name="participant_type" value="delegate" id="part_delegate" required>
                                <label for="part_delegate">Individual Delegate</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="participant_type" value="delegation" id="part_delegation" required>
                                <label for="part_delegation">Delegation</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="form-section">
                    <h2 class="form-section-title">Personal Information</h2>
                    
                    <div class="form-grid">
                        <div class="form-group form-grid-full">
                            <label for="full_name">Full Name <span class="required">*</span></label>
                            <input type="text" name="full_name" id="full_name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" id="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone_number" id="phone_number" required>
                        </div>

                        <div class="form-group">
                            <label for="whatsapp_number">WhatsApp Number <span class="required">*</span></label>
                            <input type="tel" name="whatsapp_number" id="whatsapp_number" required>
                        </div>

                        <div class="form-group">
                            <label for="cnic_number">CNIC / B-Form Number</label>
                            <input type="text" name="cnic_number" id="cnic_number">
                        </div>

                        <div class="form-group">
                            <label for="institution_name">Institution Name <span class="required">*</span></label>
                            <input type="text" name="institution_name" id="institution_name" required>
                        </div>

                        <div class="form-group">
                            <label for="education_level">Education Level <span class="required">*</span></label>
                            <select name="education_level" id="education_level" required>
                                <option value="">Select...</option>
                                <option value="O Levels">O Levels</option>
                                <option value="A Levels">A Levels</option>
                                <option value="Undergraduate">Undergraduate</option>
                                <option value="Graduate">Graduate</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Delegation Info (Hidden by default) -->
                <div class="form-section hidden" id="delegationSection">
                    <h2 class="form-section-title">Delegation Information</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="delegation_size">Delegation Size</label>
                            <input type="number" name="delegation_size" id="delegation_size" min="2" max="20">
                        </div>

                        <div class="form-group">
                            <label for="head_delegate_name">Head Delegate Name</label>
                            <input type="text" name="head_delegate_name" id="head_delegate_name">
                        </div>
                    </div>

                    <div class="delegation-members" id="delegationMembers"></div>
                    <button type="button" class="btn-add" onclick="addDelegationMember()">+ Add Delegation Member</button>
                </div>

                <!-- Committee Preferences -->
                <div class="form-section">
                    <h2 class="form-section-title">Committee Preferences</h2>
                    
                    <div class="form-group">
                        <label for="committee_preference_1">First Preference</label>
                        <select name="committee_preference_1" id="committee_preference_1">
                            <option value="">Select...</option>
                            <option value="UNSC">UNSC</option>
                            <option value="UNGA">UNGA</option>
                            <option value="UNHRC">UNHRC</option>
                            <option value="ECOSOC">ECOSOC</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="committee_preference_2">Second Preference</label>
                        <select name="committee_preference_2" id="committee_preference_2">
                            <option value="">Select...</option>
                            <option value="UNSC">UNSC</option>
                            <option value="UNGA">UNGA</option>
                            <option value="UNHRC">UNHRC</option>
                            <option value="ECOSOC">ECOSOC</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="committee_preference_3">Third Preference</label>
                        <select name="committee_preference_3" id="committee_preference_3">
                            <option value="">Select...</option>
                            <option value="UNSC">UNSC</option>
                            <option value="UNGA">UNGA</option>
                            <option value="UNHRC">UNHRC</option>
                            <option value="ECOSOC">ECOSOC</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mun_experience">MUN Experience</label>
                        <textarea name="mun_experience" id="mun_experience" placeholder="Please describe your previous MUN experience..."></textarea>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h2 class="form-section-title">Additional Information</h2>
                    
                    <div class="form-group">
                        <label for="dietary_requirements">Dietary Requirements</label>
                        <input type="text" name="dietary_requirements" id="dietary_requirements" placeholder="e.g., Vegetarian, Halal, Allergies">
                    </div>

                    <div class="form-group">
                        <label for="special_needs">Special Needs / Accommodations</label>
                        <textarea name="special_needs" id="special_needs" placeholder="Any special requirements or accommodations needed..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="reference">How did you hear about us?</label>
                        <select name="reference" id="reference">
                            <option value="">Select...</option>
                            <option value="Social Media">Social Media</option>
                            <option value="Friend">Friend / Colleague</option>
                            <option value="University">University / Institution</option>
                            <option value="Previous MUN">Previous MUN Event</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="promo_code">Promo Code (if any)</label>
                        <input type="text" name="promo_code" id="promo_code">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit Registration</button>
            </form>
        </div>
    </div>

    <script>
        let memberCount = 0;

        // Toggle delegation section
        document.querySelectorAll('input[name="participant_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const delegationSection = document.getElementById('delegationSection');
                if (this.value === 'delegation') {
                    delegationSection.classList.remove('hidden');
                } else {
                    delegationSection.classList.add('hidden');
                }
            });
        });

        function addDelegationMember() {
            memberCount++;
            const container = document.getElementById('delegationMembers');
            const memberCard = document.createElement('div');
            memberCard.className = 'member-card';
            memberCard.id = `member-${memberCount}`;
            memberCard.innerHTML = `
                <div class="member-header">
                    <span class="member-title">Member ${memberCount}</span>
                    <button type="button" class="btn-remove" onclick="removeMember(${memberCount})">Remove</button>
                </div>
                <div class="form-grid">
                    <div class="form-group form-grid-full">
                        <label>Name</label>
                        <input type="text" name="member_name[]">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="member_email[]">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="member_phone[]">
                    </div>
                    <div class="form-group">
                        <label>CNIC / B-Form</label>
                        <input type="text" name="member_cnic[]">
                    </div>
                    <div class="form-group">
                        <label>Committee Preference</label>
                        <select name="member_committee[]">
                            <option value="">Select...</option>
                            <option value="UNSC">UNSC</option>
                            <option value="UNGA">UNGA</option>
                            <option value="UNHRC">UNHRC</option>
                            <option value="ECOSOC">ECOSOC</option>
                        </select>
                    </div>
                    <div class="form-group form-grid-full">
                        <label>MUN Experience</label>
                        <textarea name="member_experience[]" rows="3"></textarea>
                    </div>
                </div>
            `;
            container.appendChild(memberCard);
        }

        function removeMember(id) {
            document.getElementById(`member-${id}`).remove();
        }
    </script>
</body>
</html>
