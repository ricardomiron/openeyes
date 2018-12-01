INSERT INTO openeyes.medication (source_type,source_subtype,preferred_term,preferred_code,vtm_term,vtm_code,vmp_term,vmp_code,amp_term,amp_code)
SELECT
	'DM+D' AS source_type,
	'AMP' AS source_subtype,

	amp.desc AS preferred_term,
	amp.apid AS preferred_code,

	vtm.nm AS vtm_term,
	vtm.vtmid AS vtm_code,

	vmp.nm AS vmp_term,
	vmp.vpid AS vmp_code,

	amp.desc AS amp_term,
	amp.apid AS amp_code
FROM
	drugs2.f_amp_amps amp
	LEFT JOIN drugs2.f_vmp_vmps vmp ON vmp.vpid = amp.vpid
	LEFT JOIN drugs2.f_vtm_vtm vtm ON vtm.vtmid = vmp.vtmid
;