<?php

namespace Database\Seeders;

use App\Models\ComplianceDeadline;
use App\Models\ComplianceRequirement;
use App\Models\LicenseActivity;
use App\Models\Regulator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UaeComplianceSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRegulators();
        $this->seedActivities();
        $this->seedRequirements();
        $this->generateDeadlines(2026);
        $this->generateDeadlines(2027);
    }

    private function seedRegulators(): void
    {
        $regulators = [
            ['name' => 'Central Bank of the UAE',           'acronym' => 'CBUAE',   'sector' => 'financial',    'website' => 'https://www.centralbank.ae',   'jurisdiction' => 'UAE Federal',    'description' => 'Federal regulator for banks, exchange houses, finance companies, payment service providers and insurance brokers in the UAE.'],
            ['name' => 'Securities and Commodities Authority','acronym' => 'SCA',    'sector' => 'financial',    'website' => 'https://www.sca.gov.ae',        'jurisdiction' => 'UAE Federal',    'description' => 'Federal regulator for securities, commodities, and derivatives markets across the UAE (excluding DIFC and ADGM).'],
            ['name' => 'Dubai Financial Services Authority', 'acronym' => 'DFSA',   'sector' => 'financial',    'website' => 'https://www.dfsa.ae',           'jurisdiction' => 'DIFC, Dubai',    'description' => 'Independent regulator of financial services conducted in or from the Dubai International Financial Centre (DIFC).'],
            ['name' => 'Financial Services Regulatory Authority','acronym' => 'FSRA','sector' => 'financial',   'website' => 'https://www.adgm.com/fsra',     'jurisdiction' => 'ADGM, Abu Dhabi','description' => 'Regulator of financial services conducted in or from the Abu Dhabi Global Market (ADGM).'],
            ['name' => 'Insurance Authority (IA)',           'acronym' => 'IA-UAE', 'sector' => 'financial',    'website' => 'https://www.ia.gov.ae',         'jurisdiction' => 'UAE Federal',    'description' => 'Federal regulator for all insurance activities and companies operating in the UAE.'],
            ['name' => 'Real Estate Regulatory Agency',      'acronym' => 'RERA',   'sector' => 'real_estate',  'website' => 'https://www.rera.gov.ae',       'jurisdiction' => 'Dubai',          'description' => 'Regulatory arm of Dubai Land Department governing real estate developers, brokers, and property managers in Dubai.'],
            ['name' => 'Dubai Land Department',              'acronym' => 'DLD',    'sector' => 'real_estate',  'website' => 'https://www.dubailand.gov.ae',  'jurisdiction' => 'Dubai',          'description' => 'Government entity responsible for real estate registration, transactions, and regulatory oversight in Dubai.'],
            ['name' => 'Abu Dhabi Real Estate Centre',       'acronym' => 'ADREC',  'sector' => 'real_estate',  'website' => 'https://www.adrec.ae',          'jurisdiction' => 'Abu Dhabi',      'description' => 'Abu Dhabi\'s real estate regulatory body overseeing developers, brokers and property management.'],
            ['name' => 'Ministry of Economy',                'acronym' => 'MoE',    'sector' => 'dnfbp',        'website' => 'https://www.economy.gov.ae',    'jurisdiction' => 'UAE Federal',    'description' => 'Federal ministry responsible for AML/CFT oversight of Designated Non-Financial Businesses and Professions (DNFBPs) including bullion dealers, auditors, accountants, and company service providers.'],
        ];
        foreach ($regulators as $d) {
            Regulator::firstOrCreate(['acronym' => $d['acronym']], $d);
        }
    }

    private function seedActivities(): void
    {
        $r = fn ($a) => Regulator::where('acronym', $a)->value('id');

        $activities = [
            ['name' => 'Commercial Banking',                       'sector' => 'financial',   'reg' => 'CBUAE', 'description' => 'Licensed commercial bank accepting deposits and providing loans.'],
            ['name' => 'Islamic Banking',                          'sector' => 'financial',   'reg' => 'CBUAE', 'description' => 'Sharia-compliant banking operations.'],
            ['name' => 'Exchange House',                           'sector' => 'financial',   'reg' => 'CBUAE', 'description' => 'Money exchange and remittance services.'],
            ['name' => 'Finance Company',                          'sector' => 'financial',   'reg' => 'CBUAE', 'description' => 'Consumer and corporate finance excluding deposit-taking.'],
            ['name' => 'Payment Service Provider',                 'sector' => 'financial',   'reg' => 'CBUAE', 'description' => 'Licensed payment processing, wallets and stored value facilities.'],
            ['name' => 'Investment Manager',                       'sector' => 'financial',   'reg' => 'SCA',   'description' => 'Manages client portfolios and investment funds.'],
            ['name' => 'Broker / Dealer',                          'sector' => 'financial',   'reg' => 'SCA',   'description' => 'Executes securities and commodities transactions on behalf of clients.'],
            ['name' => 'Investment Advisor',                       'sector' => 'financial',   'reg' => 'SCA',   'description' => 'Provides investment advice to retail and professional clients.'],
            ['name' => 'Collective Investment Scheme Operator',    'sector' => 'financial',   'reg' => 'SCA',   'description' => 'Manages and administers registered investment funds.'],
            ['name' => 'Authorised Firm – Banking',                'sector' => 'financial',   'reg' => 'DFSA',  'description' => 'Banking business conducted in or from the DIFC.'],
            ['name' => 'Authorised Firm – Arranging Deals',        'sector' => 'financial',   'reg' => 'DFSA',  'description' => 'Arranging deals in investments in the DIFC.'],
            ['name' => 'Authorised Firm – Managing Assets',        'sector' => 'financial',   'reg' => 'DFSA',  'description' => 'Discretionary management of client assets in the DIFC.'],
            ['name' => 'Authorised Firm – Insurance',              'sector' => 'financial',   'reg' => 'DFSA',  'description' => 'Insurance activities licensed by the DFSA in the DIFC.'],
            ['name' => 'Authorised Person – Banking',              'sector' => 'financial',   'reg' => 'FSRA',  'description' => 'Banking activities in or from the ADGM.'],
            ['name' => 'Authorised Person – Fund Management',      'sector' => 'financial',   'reg' => 'FSRA',  'description' => 'Managing collective investment funds in the ADGM.'],
            ['name' => 'Authorised Person – Dealing in Securities','sector' => 'financial',   'reg' => 'FSRA',  'description' => 'Dealing as principal or agent in securities in the ADGM.'],
            ['name' => 'Insurance Company',                        'sector' => 'financial',   'reg' => 'IA-UAE','description' => 'Life or non-life insurance company licensed under federal law.'],
            ['name' => 'Insurance Broker',                         'sector' => 'financial',   'reg' => 'IA-UAE','description' => 'Licensed insurance brokerage intermediary.'],
            ['name' => 'Real Estate Developer',                    'sector' => 'real_estate', 'reg' => 'RERA',  'description' => 'Registered developer of off-plan or completed real estate projects in Dubai.'],
            ['name' => 'Real Estate Broker',                       'sector' => 'real_estate', 'reg' => 'RERA',  'description' => 'Licensed real estate agent and brokerage firm in Dubai.'],
            ['name' => 'Property Management Company',              'sector' => 'real_estate', 'reg' => 'RERA',  'description' => 'Manages residential or commercial properties on behalf of owners.'],
            ['name' => 'Real Estate Valuator',                     'sector' => 'real_estate', 'reg' => 'DLD',   'description' => 'Certified property valuation professional registered with DLD.'],
            ['name' => 'Real Estate Developer (Abu Dhabi)',        'sector' => 'real_estate', 'reg' => 'ADREC', 'description' => 'Licensed property developer in Abu Dhabi.'],
            ['name' => 'Real Estate Broker (Abu Dhabi)',           'sector' => 'real_estate', 'reg' => 'ADREC', 'description' => 'Licensed real estate broker in Abu Dhabi.'],
            // ── Ministry of Economy – DNFBPs ──────────────────────────────────────
            ['name' => 'Precious Metals & Stones Dealer',          'sector' => 'bullion',             'reg' => 'MoE', 'description' => 'Business engaged in trading, broking or dealing in gold, silver, diamonds or other precious metals and stones in the UAE.'],
            ['name' => 'Audit & Accounting Firm',                  'sector' => 'professional_services','reg' => 'MoE', 'description' => 'Licensed auditing and accounting practice registered with the Ministry of Economy and UAE accountancy professional bodies.'],
            ['name' => 'Company Service Provider (CSP)',           'sector' => 'professional_services','reg' => 'MoE', 'description' => 'Business providing corporate formation, registered agent, director/nominee services, or related corporate administration services.'],
            // ── Insurance Agent ────────────────────────────────────────────────────
            ['name' => 'Insurance Agent',                          'sector' => 'financial',           'reg' => 'IA-UAE', 'description' => 'Individual or entity licensed to solicit and sell insurance products on behalf of one or more licensed insurance companies in the UAE.'],
        ];

        foreach ($activities as $d) {
            $regId = $r($d['reg']);
            LicenseActivity::firstOrCreate(
                ['name' => $d['name'], 'suggested_regulator_id' => $regId],
                ['description' => $d['description'], 'sector' => $d['sector'], 'suggested_regulator_id' => $regId]
            );
        }
    }

    private function seedRequirements(): void
    {
        foreach ($this->requirementsData() as $data) {
            $regulator = Regulator::where('acronym', $data['regulator'])->first();
            if (! $regulator) continue;

            $activityId = null;
            if (isset($data['activity'])) {
                $activityId = LicenseActivity::where('name', $data['activity'])
                    ->where('suggested_regulator_id', $regulator->id)->value('id');
            }

            ComplianceRequirement::firstOrCreate(
                ['title' => $data['title'], 'regulator_id' => $regulator->id],
                [
                    'description'         => $data['description'],
                    'license_activity_id' => $activityId,
                    'frequency'           => $data['frequency'],
                    'category'            => $data['category'] ?? 'Reporting',
                    'submission_channel'  => $data['channel'] ?? null,
                    'penalty_note'        => $data['penalty'] ?? null,
                ]
            );
        }
    }

    private function requirementsData(): array
    {
        return [
            // ── CBUAE ──────────────────────────────────────────────────────────────
            ['regulator'=>'CBUAE','title'=>'Monthly Liquidity Coverage Ratio (LCR) Return','frequency'=>'monthly','category'=>'Prudential Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','penalty'=>'Administrative sanctions including financial penalties up to AED 50 million for persistent non-compliance.','description'=>'Submit the Liquidity Coverage Ratio report to CBUAE via the Regulatory Reporting System (RRS). Banks must maintain an LCR of at least 100% at all times.'],
            ['regulator'=>'CBUAE','title'=>'Quarterly Capital Adequacy Ratio (CAR) Return','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','penalty'=>'Non-compliance may trigger supervisory intervention; failure to maintain minimum 13% CAR may result in restrictions on dividends.','description'=>'Submit Capital Adequacy Ratio (Basel III) returns including Pillar 1 capital requirements for credit, market and operational risk.'],
            ['regulator'=>'CBUAE','title'=>'Annual Audited Financial Statements Submission','frequency'=>'annual','category'=>'Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','penalty'=>'Late submission may result in administrative fines and public disclosure.','description'=>'Submit audited annual financial statements prepared under IFRS, signed by the external auditor, within 4 months of financial year-end.'],
            ['regulator'=>'CBUAE','title'=>'Annual AML/CFT Compliance Report','frequency'=>'annual','category'=>'AML/CFT','channel'=>'goAML system (Financial Intelligence Unit)','penalty'=>'Violations of AML obligations may result in fines up to AED 1 million per violation under Federal Decree-Law No. 20/2018.','description'=>'Submit the annual AML/CFT compliance report detailing risk assessments, suspicious transaction reports, staff training, and programme effectiveness.'],
            ['regulator'=>'CBUAE','title'=>'Monthly Net Stable Funding Ratio (NSFR) Return','frequency'=>'monthly','category'=>'Prudential Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','description'=>'Report the Net Stable Funding Ratio to ensure stable funding over a one-year horizon. Minimum NSFR of 100% required.'],
            ['regulator'=>'CBUAE','title'=>'Quarterly Large Exposures Return','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','description'=>'Report all exposures exceeding 10% of Tier 1 capital to a single counterparty or connected group.'],
            ['regulator'=>'CBUAE','title'=>'Annual Compliance Officer Report','frequency'=>'annual','category'=>'Governance','channel'=>'Board submission with copy to CBUAE upon request','description'=>'The Compliance Officer must submit an annual report to the Board of Directors covering compliance programme status, key findings, and remediation actions.'],
            ['regulator'=>'CBUAE','title'=>'Quarterly Credit Risk Report','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','description'=>'Submit reports on loan portfolio quality, non-performing loans, provisions and impairments in accordance with IFRS 9 and CBUAE Credit Risk Guidelines.'],
            ['regulator'=>'CBUAE','activity'=>'Exchange House','title'=>'Monthly Transaction Volume Report','frequency'=>'monthly','category'=>'Statistical Reporting','channel'=>'CBUAE Regulatory Reporting System (RRS)','description'=>'Report total remittance and exchange transaction volumes, broken down by corridor and currency, to CBUAE.'],
            ['regulator'=>'CBUAE','activity'=>'Exchange House','title'=>'Annual Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'CBUAE Online Portal','penalty'=>'Operating without a valid licence is a criminal offence under the CBUAE Law.','description'=>'Renew the exchange house operating licence with CBUAE. Submit renewal application with updated KYC, financial statements and compliance attestations.'],
            // ── SCA ────────────────────────────────────────────────────────────────
            ['regulator'=>'SCA','title'=>'Quarterly Financial Condition Report','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'SCA E-Services Portal','penalty'=>'Administrative fine of AED 10,000–500,000 for late or inaccurate submission.','description'=>'Submit quarterly financial statements showing net capital, client money balances, and financial condition to SCA.'],
            ['regulator'=>'SCA','title'=>'Annual Audited Financial Statements','frequency'=>'annual','category'=>'Reporting','channel'=>'SCA E-Services Portal','penalty'=>'Fine and potential suspension of licence for persistent late submission.','description'=>'Submit externally audited annual financial statements to SCA within 3 months of the financial year-end.'],
            ['regulator'=>'SCA','title'=>'Annual Compliance Officer Report','frequency'=>'annual','category'=>'Governance','channel'=>'SCA E-Services Portal','description'=>'Compliance Officer submits an annual report to the Board and SCA covering programme effectiveness, breaches, and remediation.'],
            ['regulator'=>'SCA','title'=>'Annual AML/CFT Report','frequency'=>'annual','category'=>'AML/CFT','channel'=>'SCA E-Services Portal & goAML','description'=>'Submit the annual AML/CFT compliance report to SCA covering risk assessment results, STR statistics, training records, and programme enhancements.'],
            ['regulator'=>'SCA','title'=>'Annual Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'SCA E-Services Portal','penalty'=>'Licence lapses if not renewed by deadline. Operating with lapsed licence results in criminal liability.','description'=>'Renew SCA operating licence annually. Submit fit and proper forms for key persons, updated business plan, and financial standing evidence.'],
            ['regulator'=>'SCA','title'=>'Monthly Client Money Reconciliation Report','frequency'=>'monthly','category'=>'Client Assets','channel'=>'SCA E-Services Portal','description'=>'Submit monthly client money reconciliation confirming segregation of client assets from firm assets.'],
            // ── DFSA ───────────────────────────────────────────────────────────────
            ['regulator'=>'DFSA','title'=>'Quarterly Prudential Return (PIB/PII)','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'DFSA Online Regulatory System','penalty'=>'DFSA may impose financial penalties up to USD 500,000 and take enforcement action for late or inaccurate returns.','description'=>'Submit the quarterly Prudential Investment Business (PIB) or Prudential Insurance Business (PII) return covering capital adequacy, liquidity, and risk exposures.'],
            ['regulator'=>'DFSA','title'=>'Annual Audited Financial Accounts','frequency'=>'annual','category'=>'Reporting','channel'=>'DFSA Online Regulatory System','description'=>'File audited annual accounts with the DFSA within 4 months of financial year-end. Accounts must comply with IFRS as adopted in the DIFC.'],
            ['regulator'=>'DFSA','title'=>'Annual Compliance Report','frequency'=>'annual','category'=>'Governance','channel'=>'DFSA Online Regulatory System','penalty'=>'Failure to submit is a contravention that may result in a public censure or fine.','description'=>'The Senior Executive Officer (SEO) or Compliance Officer submits an annual compliance report to the DFSA within 4 months of year-end.'],
            ['regulator'=>'DFSA','title'=>'Annual AML Return','frequency'=>'annual','category'=>'AML/CFT','channel'=>'DFSA Online Regulatory System','description'=>'Submit the annual AML return to DFSA detailing customer risk profile, STR/SAR statistics, and AML programme enhancements.'],
            ['regulator'=>'DFSA','title'=>'Annual Authorised Firm Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'DFSA Online Regulatory System','penalty'=>'Operating without a valid DFSA licence in the DIFC is a criminal offence under DIFC Law No. 1 of 2004.','description'=>'Pay the annual licence fee and confirm material information about the firm, its key persons, and controlled functions with the DFSA.'],
            ['regulator'=>'DFSA','title'=>'Semi-Annual Large Exposure Report','frequency'=>'semi_annual','category'=>'Prudential Reporting','channel'=>'DFSA Online Regulatory System','description'=>'Report all exposures exceeding the DFSA\'s large exposure thresholds twice per year.'],
            // ── FSRA ───────────────────────────────────────────────────────────────
            ['regulator'=>'FSRA','title'=>'Quarterly Prudential Return','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'ADGM Online Portal','penalty'=>'FSRA may impose a financial penalty and/or restrict regulated activities for late or incomplete submissions.','description'=>'Submit quarterly capital adequacy and liquidity return to FSRA covering minimum capital requirements, liquid assets, and risk exposures.'],
            ['regulator'=>'FSRA','title'=>'Annual Audited Financial Statements','frequency'=>'annual','category'=>'Reporting','channel'=>'ADGM Online Portal','description'=>'File IFRS-compliant audited annual accounts with FSRA within 4 months of year-end.'],
            ['regulator'=>'FSRA','title'=>'Annual Compliance Report','frequency'=>'annual','category'=>'Governance','channel'=>'ADGM Online Portal','description'=>'Submit the annual compliance report to FSRA summarising the effectiveness of compliance arrangements and any material breaches or incidents.'],
            ['regulator'=>'FSRA','title'=>'Annual AML/CFT Return','frequency'=>'annual','category'=>'AML/CFT','channel'=>'ADGM Online Portal','description'=>'Complete and submit the FSRA\'s annual AML/CFT return covering customer risk profiling, STR data, and programme assessment.'],
            ['regulator'=>'FSRA','title'=>'Annual Licence Fee and Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'ADGM Online Portal','description'=>'Pay annual FSRA licence fee and confirm continuing fitness and propriety of key persons and controlled functions.'],
            // ── RERA / DLD ─────────────────────────────────────────────────────────
            ['regulator'=>'RERA','title'=>'Annual Broker Licence Renewal (Trakheesi)','frequency'=>'annual','category'=>'Licensing','channel'=>'Trakheesi (DLD / RERA) Portal','penalty'=>'Operating without a valid broker licence is subject to fines up to AED 50,000 and blacklisting.','description'=>'Renew the real estate broker registration and individual broker cards via the Trakheesi system. Requires completion of mandatory DREI training course.'],
            ['regulator'=>'RERA','title'=>'Annual DREI Continuing Education (CPD)','frequency'=>'annual','category'=>'Training','channel'=>'Dubai Real Estate Institute (DREI)','penalty'=>'Failure to complete CPD prevents licence renewal.','description'=>'Real estate brokers must complete the Dubai Real Estate Institute (DREI) mandatory continuing professional development hours annually for licence renewal.'],
            ['regulator'=>'RERA','activity'=>'Real Estate Developer','title'=>'Quarterly Escrow Account Report','frequency'=>'quarterly','category'=>'Escrow Reporting','channel'=>'RERA Developer Portal (Oqood)','penalty'=>'Administrative fines and potential project freeze for non-compliance with escrow regulations under Law No. 8 of 2007.','description'=>'Developers must submit quarterly reports on off-plan project escrow accounts to RERA, confirming balances, withdrawals, and construction progress milestones.'],
            ['regulator'=>'RERA','activity'=>'Real Estate Developer','title'=>'Annual Project Progress Report','frequency'=>'annual','category'=>'Project Reporting','channel'=>'RERA Developer Portal (Oqood)','description'=>'Submit annual project status update to RERA including construction milestones achieved, unit sales, and escrow utilisation versus project budget.'],
            ['regulator'=>'RERA','activity'=>'Property Management Company','title'=>'Annual Service Charge Budget Filing','frequency'=>'annual','category'=>'Financial Reporting','channel'=>'Mollak System (RERA)','penalty'=>'Service charge invoices cannot be issued to owners without RERA-approved budget.','description'=>'Submit the annual service charge budget for managed communities to RERA for approval before the start of each fiscal year.'],
            ['regulator'=>'DLD','title'=>'Annual Valuator Registration Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'DLD Online Portal','description'=>'Renew certified valuator registration with the Dubai Land Department. Must demonstrate active valuation practice and CPD compliance.'],

            // ── Ministry of Economy – DNFBP (all sectors) ─────────────────────────
            ['regulator'=>'MoE','title'=>'goAML Registration & Annual Renewal','frequency'=>'annual','category'=>'AML/CFT','channel'=>'goAML Portal (UAE Financial Intelligence Unit)','penalty'=>'Failure to register on goAML is a violation of Federal Decree-Law No. 20/2018 and may result in fines up to AED 1 million.','description'=>'All DNFBPs must register on the UAE FIU\'s goAML platform and keep registration active. Used to submit Suspicious Transaction Reports (STRs) and comply with AML/CFT obligations.'],
            ['regulator'=>'MoE','title'=>'Annual AML/CFT Risk Assessment','frequency'=>'annual','category'=>'AML/CFT','channel'=>'Ministry of Economy DNFBP Portal','penalty'=>'Failure to conduct and document an annual risk assessment may result in administrative sanctions under Cabinet Decision No. 10/2019.','description'=>'DNFBPs must conduct, document, and submit an annual enterprise-wide AML/CFT risk assessment covering business activities, customer types, geographic exposure, and products/services.'],
            ['regulator'=>'MoE','title'=>'Annual AML/CFT Compliance Report','frequency'=>'annual','category'=>'AML/CFT','channel'=>'Ministry of Economy DNFBP Portal','penalty'=>'Non-submission or late submission may result in financial penalties and reputational sanctions published by MoE.','description'=>'Submit the annual AML/CFT compliance report to the Ministry of Economy covering the firm\'s compliance programme, STR statistics, staff training records, and risk mitigation measures.'],
            ['regulator'=>'MoE','title'=>'Ultimate Beneficial Owner (UBO) Register Filing','frequency'=>'annual','category'=>'Governance','channel'=>'Ministry of Economy / Relevant Licensing Authority Portal','penalty'=>'Failure to maintain or submit UBO information is an offence under Cabinet Decision No. 109/2023 with fines up to AED 100,000.','description'=>'Maintain and annually confirm the Ultimate Beneficial Owner register with the relevant licensing authority, identifying all natural persons who own or control 25% or more of the entity.'],

            // ── Precious Metals & Stones Dealer (Bullion) ─────────────────────────
            ['regulator'=>'MoE','activity'=>'Precious Metals & Stones Dealer','title'=>'Annual Precious Metals & Stones Dealer Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'Ministry of Economy / DMCC Portal','penalty'=>'Trading without a valid licence is a criminal offence. Penalties include business closure and fines.','description'=>'Renew the annual operating licence for precious metals and stones dealing with the Ministry of Economy or relevant free zone authority (e.g. DMCC). Submit KYC documents, audited financials, and compliance attestation.'],
            ['regulator'=>'MoE','activity'=>'Precious Metals & Stones Dealer','title'=>'Quarterly Customer Due Diligence (CDD) Review','frequency'=>'quarterly','category'=>'AML/CFT','channel'=>'Internal records; available for MoE inspection','description'=>'Review and update customer due diligence files quarterly for high-risk clients. Document source of funds, purpose of transactions, and PEP/sanctions screening results.'],
            ['regulator'=>'MoE','activity'=>'Precious Metals & Stones Dealer','title'=>'Annual Physical Stock Reconciliation & Audit','frequency'=>'annual','category'=>'Reporting','channel'=>'Internal records; available for MoE inspection','description'=>'Conduct and document an annual physical stock count of all precious metals and stones inventory, reconciling with purchase/sale records. Results must be available for regulatory inspection.'],

            // ── Audit & Accounting Firm ────────────────────────────────────────────
            ['regulator'=>'MoE','activity'=>'Audit & Accounting Firm','title'=>'Annual Audit Firm Registration Renewal (MoE)','frequency'=>'annual','category'=>'Licensing','channel'=>'Ministry of Economy Online Portal','penalty'=>'Practising audit without a valid MoE registration is prohibited under Federal Law No. 12/2014. Penalties include licence revocation.','description'=>'Renew the annual audit and accounting firm registration with the Ministry of Economy. Confirm the firm\'s licensed partners, auditor qualifications, and professional indemnity insurance.'],
            ['regulator'=>'MoE','activity'=>'Audit & Accounting Firm','title'=>'Annual Audit Quality Inspection Readiness Report','frequency'=>'annual','category'=>'Governance','channel'=>'Ministry of Economy / UAE Accountants and Auditors Association (AAA)','description'=>'Prepare and submit the annual quality assurance self-assessment to the MoE/AAA, covering audit methodology, file review results, independence checks, and CPD compliance of all partners and staff.'],

            // ── Company Service Provider ───────────────────────────────────────────
            ['regulator'=>'MoE','activity'=>'Company Service Provider (CSP)','title'=>'Annual CSP Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'Ministry of Economy DNFBP Portal','penalty'=>'Operating as an unlicensed CSP is an offence. Penalties include fines up to AED 500,000 and criminal referral.','description'=>'Renew the Company Service Provider operating licence with the Ministry of Economy. Submit updated fit and proper declarations for controllers, AML/CFT policy documentation, and client register evidence.'],
            ['regulator'=>'MoE','activity'=>'Company Service Provider (CSP)','title'=>'Annual UBO Database Filing for Managed Entities','frequency'=>'annual','category'=>'Governance','channel'=>'Ministry of Economy / Relevant Licensing Authority Portal','description'=>'File and confirm UBO information for all entities under the CSP\'s registered agent or nominee services. Ensure all beneficial ownership records are current and submitted to the relevant authority.'],

            // ── Insurance Agent (IA-UAE) ───────────────────────────────────────────
            ['regulator'=>'IA-UAE','activity'=>'Insurance Agent','title'=>'Annual Insurance Agent Licence Renewal','frequency'=>'annual','category'=>'Licensing','channel'=>'Insurance Authority E-Services Portal','penalty'=>'Soliciting insurance business without a valid licence is a criminal offence under Federal Law No. 6/2007. Penalties include fines up to AED 1 million.','description'=>'Renew the insurance agent licence with the Insurance Authority (IA). Submit updated appointments from principal insurers, professional indemnity insurance certificate, and fit and proper declarations.'],
            ['regulator'=>'IA-UAE','activity'=>'Insurance Agent','title'=>'Annual Professional Development Training (Insurance)','frequency'=>'annual','category'=>'Training','channel'=>'IA-Approved Training Providers','description'=>'Complete the Insurance Authority\'s mandatory annual continuing professional development (CPD) hours to maintain licence eligibility and enhance product knowledge and compliance awareness.'],

            // ── Insurance Company & Broker (IA-UAE) – additional requirements ──────
            ['regulator'=>'IA-UAE','title'=>'Quarterly Financial Solvency Return','frequency'=>'quarterly','category'=>'Prudential Reporting','channel'=>'Insurance Authority E-Services Portal','penalty'=>'Failure to maintain solvency margins triggers regulatory intervention including business restrictions and potential revocation.','description'=>'Submit quarterly solvency margin calculations to the Insurance Authority demonstrating that minimum capital requirements under Financial Regulations for Insurance Companies are met at all times.'],
            ['regulator'=>'IA-UAE','title'=>'Annual Audited Financial Statements','frequency'=>'annual','category'=>'Reporting','channel'=>'Insurance Authority E-Services Portal','penalty'=>'Late or non-submission results in administrative fines and public disclosure by the IA.','description'=>'Submit externally audited annual financial statements to the Insurance Authority within 3 months of the financial year-end, prepared under IFRS and signed by an IA-approved external auditor.'],
        ];
    }

    private function generateDeadlines(int $year): void
    {
        foreach (ComplianceRequirement::with('regulator')->get() as $req) {
            foreach ($this->computeDeadlines($req, $year) as $deadline) {
                ComplianceDeadline::firstOrCreate(
                    ['requirement_id' => $req->id, 'due_date' => $deadline['date'], 'year' => $year],
                    ['title' => $deadline['title'], 'notes' => $deadline['notes'] ?? null]
                );
            }
        }
    }

    private function computeDeadlines(ComplianceRequirement $req, int $year): array
    {
        $deadlines = [];
        switch ($req->frequency) {
            case 'monthly':
                for ($m = 1; $m <= 12; $m++) {
                    $due = Carbon::create($year, $m, 1)->endOfMonth()->addDays(15);
                    if ($due->year !== $year) continue;
                    $deadlines[] = ['date' => $due->toDateString(), 'title' => $req->title.' – '.Carbon::create($year,$m,1)->format('M Y')];
                }
                break;
            case 'quarterly':
                foreach ([['end'=>Carbon::create($year,3,31),'label'=>'Q1'],['end'=>Carbon::create($year,6,30),'label'=>'Q2'],['end'=>Carbon::create($year,9,30),'label'=>'Q3'],['end'=>Carbon::create($year,12,31),'label'=>'Q4']] as $q) {
                    $deadlines[] = ['date' => $q['end']->copy()->addDays(30)->toDateString(), 'title' => $req->title.' – '.$q['label'].' '.$year];
                }
                break;
            case 'semi_annual':
                foreach ([['end'=>Carbon::create($year,6,30),'label'=>'H1'],['end'=>Carbon::create($year,12,31),'label'=>'H2']] as $p) {
                    $due = $p['end']->copy()->addDays(45);
                    $deadlines[] = ['date' => $due->toDateString(), 'title' => $req->title.' – '.$p['label'].' '.$year];
                }
                break;
            case 'annual':
                $due = $this->annualDueDate($req, $year);
                $deadlines[] = ['date' => $due->toDateString(), 'title' => $req->title.' – '.$year, 'notes' => 'For financial year ended 31 December '.$year];
                break;
        }
        return $deadlines;
    }

    private function annualDueDate(ComplianceRequirement $req, int $year): Carbon
    {
        if (in_array($req->category, ['Licensing','Training'])) return Carbon::create($year, 12, 31);
        if (in_array($req->regulator->acronym, ['DFSA','FSRA','CBUAE'])) return Carbon::create($year + 1, 4, 30);
        if (in_array($req->regulator->acronym, ['SCA','IA-UAE'])) return Carbon::create($year + 1, 3, 31);
        if ($req->regulator->acronym === 'MoE') return Carbon::create($year + 1, 3, 31);
        return Carbon::create($year + 1, 3, 31);
    }
}
