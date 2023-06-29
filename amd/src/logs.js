import {wwwroot} from 'core/config';

// TODO: Maybe add possibility to log multiple actions at once (would be useful in grademonitor).

/**
 * @module log
 */

/** @const {string} The URL to which the beacon containing logging data is sent. */
const URL = wwwroot + '/local/lytix/modules/logs/endpoint/store_activities.php';

/**
 * This represents the interface to the logging backend.
 * It is advised to not use it directly and instead use makeLoggingFunction to create a custom logging function.
 *
 * @function
 * @name addActionLog
 * @param {string} userid  The user ID.
 * @param {string} courseid  The course ID.
 * @param {string} contextid  The context ID.
 * @param {string} widget  The name of the LYTIX widget logging.
 * @param {string} type  This should be an uppercase verb, describing what is being done with target.
 * @param {string} target  This should be an uppercase noun, representing the target of what is specified by type.
 * @param {string} meta  If further information needs to be included, this is the place.
 * @param {number} targetid  If the target has an ID by which it can be found in any database, include it here. Defaults to -1.
 */
export const addActionLog = (userid, courseid, contextid, widget, type, target, meta, targetid = -1) => {
    navigator.sendBeacon(
        URL,
        JSON.stringify({
            userid: userid,
            courseid: courseid,
            contextid: contextid,
            widget: widget,
            type: type,
            target: target,
            targetid: targetid,
            meta: meta,
            // Math.floor is necessary to cut off any possible decimals to prevent a float from being passed to BE.
            timestamp: Math.floor(Date.now() / 1000),
        })
    );
};

/**
 * This creates a custom function that can be called with far less parameters than addActionLog.
 *
 * @function
 * @name makeLoggingFunction
 * @param {string} userid
 * @param {string} courseid
 * @param {string} contextid
 * @param {string} widget  The name of the LYTIX widget logging.
 * @return {function}  A function that does the same as addActionLog but with a fraction of the parameters.
 */
export const makeLoggingFunction = (userid, courseid, contextid, widget) => {
    /**
     * @function
     * @param {string} type  This should be an uppercase verb, describing what is being done with target.
     * @param {string} target  This should be an uppercase noun, representing the target of what is specified by type.
     * @param {string} meta  If further information needs to be included, this is the place.
     * @param {string} targetid  If the target has an ID by which it can be found in any database, include it here.
     *
     * @todo Just refer to addActionLog instead of listing the parameters again.
     */
    return (type, target, meta, targetid) => {
        addActionLog(userid, courseid, contextid, widget, type, target, meta, targetid);
    };
};
